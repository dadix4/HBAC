<?php

namespace App\Controller\Ecommerce;

use App\Entity\Ecommerce\Panier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Ecommerce\Commandes;


class CommandesController extends Controller
{
    public function adresseLivraison()
    {
        $em = $this->getDoctrine()->getManager();
        $session = $this->get('request_stack')->getCurrentRequest()->getSession();
        $adresse = $session->get('adresse');

        $livraison = $em->getRepository('App:Utilisateurs\UserAdresses')->find($adresse['livraison']);

        return $livraison;

    }

    public function adresseFacturation()
    {
        $em = $this->getDoctrine()->getManager();
        $session = $this->get('request_stack')->getCurrentRequest()->getSession();
        $adresse = $session->get('adresse');

        $facturation = $em->getRepository('App:Utilisateurs\UserAdresses')->find($adresse['facturation']);

        return $facturation;

    }

    public function facture()
    {
        $em = $this->getDoctrine()->getManager();
        $session = $this->get('request_stack')->getCurrentRequest()->getSession();
        $generator = random_bytes(10);
        $adresse = $session->get('adresse');
        $panier = $session->get('panier');
        $commande = array();
        $totalHT = 0;
        $totalTVA = 0;

        $facturation = $em->getRepository('App:Utilisateurs\UserAdresses')->find($adresse['facturation']);
        $livraison = $em->getRepository('App:Utilisateurs\UserAdresses')->find($adresse['livraison']);
        $produits = $em->getRepository('App:Ecommerce\Produits')->findArray(array_keys($session->get('panier')));

        foreach ($produits as $produit) {
            $prixHT = ($produit->getPrix() * $panier[$produit->getId()]);
            $prixTTC = ($produit->getPrix() * $panier[$produit->getId()] * $produit->getTva()->getMultiplicate());
            $totalHT += $prixHT;
            if (!isset($commande['tva']['%' . $produit->getTva()->getValeur()])) {
                $commande['tva']['%' . $produit->getTva()->getValeur()] = round($prixTTC - $prixHT, 2);
            } else {
                $commande['tva']['%' . $produit->getTva()->getValeur()] += round($prixTTC - $prixHT, 2);
            }

            $totalTVA += round($prixTTC - $prixHT, 2);
            $commande['produit'][$produit->getId()] = array(
                'reference' => $produit->getNom(),
                'quantite' => $panier[$produit->getId()],
                'prixHT' => round($produit->getPrix(), 2),
                'prixTTC' => round($produit->getPrix() * $produit->getTva()->getMultiplicate(), 2));
        }

        $commande['livraison'] = array('prenom' => $livraison->getPrenom(),
            'nom' => $livraison->getNom(),
            'telephone' => $livraison->getTelephone(),
            'adresse' => $livraison->getAdresse(),
            'cp' => $livraison->getCP(),
            'ville' => $livraison->getVille(),
            'pays' => $livraison->getPays(),
            'complement' => $livraison->getComplement());

        $commande['facturation'] = array('prenom' => $facturation->getPrenom(),
            'nom' => $facturation->getNom(),
            'telephone' => $facturation->getTelephone(),
            'adresse' => $facturation->getAdresse(),
            'cp' => $facturation->getCP(),
            'ville' => $facturation->getVille(),
            'pays' => $facturation->getPays(),
            'complement' => $facturation->getComplement());

        $commande['prixHT'] = round($totalHT, 2);
        $commande['prixTTC'] = round($totalHT + $totalTVA, 2);
        $commande['token'] = bin2hex($generator);
        return $commande;
    }

    /*
     * On enregistre la commande en base de donnée avant le paiement du client.
     * Ou on modifie la commande en cour du client avant paiement.
     */
    public function prepareCommandeAction(Request $request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();

        $monPanier = $session->get('panier');

        //on recupère et stock les ID de produits de la session panier dans un array.
        $productsPanier = $em->getRepository('App:Ecommerce\Produits')->findArray(array_keys($monPanier));
        $produitsPanier = array();
        //On initialise les variables pour les totaux prix
        $totalHT = 0;$totalTVA = 0;$totalTTC = 0;
        foreach ($productsPanier as $productPanier) {
            $leProduit = $em->getRepository('App:Ecommerce\Produits')->find($productPanier->getId());

            $produitsPanier[] = $productPanier->getId();

            $quantite = $monPanier[$productPanier->getId()];
            $prixHT = round($quantite * $leProduit->getPrix(), 2);
            $prixTTC = round($prixHT * $leProduit->getTva()->getMultiplicate(), 2);
            $prixTVA = round($prixTTC - $prixHT);
            //Calcule des totaux pour la commande
            $totalHT += round($prixHT, 2);
            $totalTVA += round($prixTVA, 2);
            $totalTTC += round($prixTTC, 2);
        }

        //on créé une nouvelle commande et on ajoute les produits du panier
        if (!$session->has('commande')) {
            $commande = new Commandes();

            foreach ($produitsPanier as $produit) {
                $panier = new Panier();

                $quantite = $monPanier[$produit];
                $tarifHT = round($quantite * $leProduit->getPrix(), 2);
                $tarifTTC = round($tarifHT * $leProduit->getTva()->getMultiplicate(), 2);
                $Tva = round($tarifTTC - $tarifHT);

                $panier->setProduit($leProduit);
                $panier->setQuantite($quantite);
                $panier->setPrixUnitaireHT($tarifHT);
                $panier->setPrixUnitaireTTC($tarifTTC);
                $panier->setTvaUnitaire($Tva);
                $panier->setCommande($commande);
                $em->persist($panier);
            }

        //Ou on recupère la commande et les produits pour les modifier si déjà créé.
        } else {
            $commande = $em->getRepository('App:Ecommerce\Commandes')->find($session->get('commande'));
            //On recherche les paniers enregistrés sur notre commande en cour.
            $panierProduits = $em->getRepository('App:Ecommerce\Panier')->findByCommande($commande);

            //On stock dans un array les ID produits déjà enregistrés dans la commande .
            $produits = array();
            foreach ($panierProduits as $panierProduit) {
                $produits[] = $panierProduit->getProduit()->getId();
            }

            /*
             * On compare si les produits de la session panier sont différent de nos produits enregistré sur notre commande en cour
             * Si oui on rajoute les nouveaux produits et supprime ceux enlevés
             * Si non on update si besoin les quantités
             */
            //on compare les produits déjà enregistrés dans la commande à ceux de la session panier
            //si une valeur est retournée cela signifie que la client ne souhaite plus se produit alors on le supprimer.
            $produitsAsupprimer = array_diff($produits, $produitsPanier);
            foreach ($produitsAsupprimer as $produit) {
                $panierAsupprimer = $em->getRepository('App:Ecommerce\Panier')->findOneBy(array(
                    'produit' => $produit,
                    'commande' => $commande
                ));
                $em->remove($panierAsupprimer);
            }

            //on compare l'inverse, les produits de la session à ceux déjà enregistré. On enregistré les produits retournés de la comparaison
            $produitsAajouter = array_diff($produitsPanier, $produits);
            foreach ($produitsAajouter as $produit) {
                $leProduit = $em->getRepository('App:Ecommerce\Produits')->find($produit);
                $panier = new Panier();

                $quantite = $monPanier[$produit];
                $tarifHT = round($quantite * $leProduit->getPrix(), 2);
                $tarifTTC = round($tarifHT * $leProduit->getTva()->getMultiplicate(), 2);
                $Tva = round($tarifTTC - $tarifHT);

                $panier->setProduit($leProduit);
                $panier->setQuantite($quantite);
                $panier->setPrixUnitaireHT($tarifHT);
                $panier->setPrixUnitaireTTC($tarifTTC);
                $panier->setTvaUnitaire($Tva);
                $panier->setCommande($commande);
                $em->persist($panier);
            }

            //on controle seulement les produits identique dans session et ceux enregistrés pour les éditer si besoin.
            $produitsAediter = array_intersect($produitsPanier, $produits);
            foreach ($produitsAediter as $produit) {
                $leProduit = $em->getRepository('App:Ecommerce\Produits')->find($produit);
                $panier = $em->getRepository('App:Ecommerce\Panier')->findOneBy(array(
                    'produit' => $leProduit,
                    'commande' => $commande));

                $quantite = $monPanier[$produit];
                $tarifHT = round($quantite * $leProduit->getPrix(), 2);
                $tarifTTC = round($tarifHT * $leProduit->getTva()->getMultiplicate(), 2);
                $Tva = round($tarifTTC - $tarifHT);

                $panier->setProduit($leProduit);
                $panier->setQuantite($quantite);
                $panier->setPrixUnitaireHT($tarifHT);
                $panier->setPrixUnitaireTTC($tarifTTC);
                $panier->setTvaUnitaire($Tva);
                $panier->setCommande($commande);

            }

        }
        $commande->setTotalHT($totalHT);
        $commande->setTotalTVA($totalTVA);
        $commande->setTotalTTC($totalTTC);
        $commande->setDate(new \DateTime());
        $commande->setUtilisateur($this->container->get('security.token_storage')->getToken()->getUser());
        $commande->setValider(0);
        $commande->setReference(0);
        $commande->setCommandes($this->facture());
        $commande->setAdresseFacturation($this->adresseFacturation());
        $commande->setAdresseLivraison($this->adresseLivraison());

        //on persit si la commande est nouvelle
        if (!$session->has('commande')) {
            $em->persist($commande);
            $session->set('commande', $commande);
        }

        $em->flush();
        return new Response($commande->getId());
    }

    /*
    * Cette methode remplace l'API banque
    */
    public function validationCommandeAction($id, Request $request,  \Swift_Mailer $mailer)
    {
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository('App:Ecommerce\Commandes')->find($id);
        $user = $this->getUser();


        \Stripe\Stripe::setApiKey("sk_test_bhNkc0yIrYNbdaIJbyYWkuhV");

        // Token is created using Checkout or Elements!
        // Get the payment token ID submitted by the form:
        $token = $_POST['stripeToken'];

        //si le client n'a jamais fais d'achat la valeur "Client stripe" est vide donc on enregistre un nouveau client.
        //Sinon on le met à jour.
        if ( empty($clientStripe = $user->getIdStripe())) {
            $customer = \Stripe\Customer::create(array(
                'email' => $commande->getUtilisateur()->getEmailCanonical(),
                'card' => $token,
                'metadata' => array(
                    "Prénom" => $commande->getAdresseFacturation()->getPrenom(),
                    "Nom" => $commande->getAdresseFacturation()->getNom(),
                    "Adresse Facturation" =>
                        $commande->getAdresseFacturation()->getAdresse() .
                        $commande->getAdresseFacturation()->getComplement() .
                        $commande->getAdresseFacturation()->getCp() .
                        $commande->getAdresseFacturation()->getVille(),
                    "Adresse Livraison" =>
                        $commande->getAdresseLivraison()->getAdresse() .
                        $commande->getAdresseLivraison()->getComplement() .
                        $commande->getAdresseLivraison()->getCp() .
                        $commande->getAdresseLivraison()->getVille(),
                )));
        } else {
            $customer = \Stripe\Customer::retrieve($clientStripe);
        }
        // Charge the user's card:
        $charge = \Stripe\Charge::create(array(
            "amount" => $commande->getTotalTTC() * 100,
            "currency" => "eur",
            "description" => "Boutique Hbaclub.fr",
            "statement_descriptor" => "Custom descriptor",
            "customer" => $customer->id,
        ));

        $user->setIdStripe($customer->id);
        $commande->setValider(1);
        $commande->setReference($this->container->get('setNewReference')->reference()); //Service a faire //
        $em->flush();

        $session = $request->getSession();
        $session->remove('adresse');
        $session->remove('panier');
        $session->remove('commande');


        // ici le mail de validation
        $message = (new \Swift_Message())
            ->setSubject('Validation de votre commande')
            ->setFrom(array('webmaster@hbaclub.fr' => "Boutique HBAC Sainte-Pazanne"))
            ->setTo($commande->getUtilisateur()->getEmailCanonical())
            ->setCharset('utf-8')
            ->setContentType('text/html')
            ->setBody($this->renderView('boutique/mails/mailValidationCommande.html.twig', array('utilisateur' => $commande->getUtilisateur())));

        $mailer->send($message);


        $this->get('session')->getFlashBag()->add('success', 'Votre commande est validée avec succès');
        return $this->redirect($this->generateUrl('user_mes_commandes'));
    }
}
