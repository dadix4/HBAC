<?php

namespace App\Controller\Ecommerce;

use App\Entity\Ecommerce\Commandes;
use App\Entity\Ecommerce\Panier;
use App\Entity\Utilisateurs\UserAdresses;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Form\Utilisateurs\UtilisateursAdressesType;

class PanierController extends Controller
{
  public function menuAction(Request $request)
  {
      $session = $request->getSession();

   if (!$session->has('panier'))
        $session->set('panier',array());
        $panier = $session->get('panier');
        $articles = count($session->get('panier'));


    $em = $this->getDoctrine()->getManager();
    $produits = $em->getRepository('App:Ecommerce\Produits')->findArray(array_keys($panier));

    return $this->render('boutique/panier/topBarPanier.html.twig', array('produits' => $produits,
                                                                                   'articles' => $articles,
                                                                                    'panier' => $panier));
  }

    public function leftBarPanierAction(Request $request)
    {
        $session = $request->getSession();

        if (!$session->has('panier'))
            $session->set('panier',array());
        $panier = $session->get('panier');
        $articles = count($session->get('panier'));


        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('App:Ecommerce\Produits')->findArray(array_keys($panier));

        return $this->render('boutique/panier/leftBarPanier.html.twig', array('produits' => $produits,
            'articles' => $articles,
            'panier' => $panier));
    }

  public function supprimerAction($id, Request $request)
  {
    //On récupère la session panier
    $session = $request->getSession();
    $panier = $session->get('panier');

    if (array_key_exists($id, $panier))
    {
      unset($panier[$id]);
      $session->set('panier',$panier);
      $this->get('session')->getFlashBag()->add('success','Article supprimé avec succès');
    }
    return $this->redirect($this->generateUrl('boutique_panier'));
  }

    public function ajouterAction($id, Request $request)
    {
      //METHODE QUI PERMET D'ENREGISTRER DANS UNE SESSION LA QUANTITE
      //DEMANDE PAR L'USER POUR CHAQUE PRODUIT
      //Creation d'une session
      $session = $request->getSession();
      //Si une session n'existe pas, on la cré et la nomme panier
      if (!$session->has('panier')) $session->set('panier',array());
      $panier = $session->get('panier');// on affecte une variable $panier à notre session.

      if (array_key_exists($id, $panier)) {
          if ($request->query->get('qte') != null) $panier[$id] = $request->query->get('qte');
          $this->get('session')->getFlashBag()->add('success','la quantité a été modifié avec succès');

          $session->set('panier',$panier);
          return $this->redirect($this->generateUrl('boutique_panier'));
      } else {
          if ($request->query->get('qte') != null)
          {
          $panier[$id] = $request->query->get('qte');
          } else {
          $panier[$id] = 1;
          }
          $this->get('session')->getFlashBag()->add('success','Le produit a été ajouté à votre panier.');

          $session->set('panier',$panier);
          return $this->redirect($this->generateUrl('boutique_produit'));
      }
    }

    public function panierAction(Request $request)
    {
      $session = $request->getSession();

      if (!$session->has('panier')) $session->set('panier',array());
      $panier = $session->get('panier');

      $em = $this->getDoctrine()->getManager();
      $produits = $em->getRepository('App:Ecommerce\Produits')->findArray(array_keys($panier));

      return $this->render('boutique/panier/panier.html.twig', array('produits' => $produits,
                                                                               'panier' => $panier));
    }

    public function adresseSuppressionAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('App:Utilisateurs\UserAdresses')->find($id);
        if ($this->container->get('security.token_storage')->getToken()->getUser() != $entity->getUtilisateur() || !$entity)
        {
            return $this->redirect($this->generateUrl('boutique_panier_livraison'));
        }
        $em->remove($entity);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success','Adresse supprimée');
        return $this->redirect($this->generateUrl('boutique_panier_livraison'));

    }

    public function livraisonAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $utilisateur = $this->container->get('security.token_storage')->getToken()->getUser();
      $entity = new UserAdresses();
      $form = $this->createForm(UtilisateursAdressesType::class, $entity, array(
          'entity_manager' => $em ));

      if ($request->getMethod() == 'POST')
       {
           $form->handleRequest($request);
           if ($form->isSubmitted() && $form->isValid())
           {
               $em = $this->getDoctrine()->getManager();
               $entity->setUtilisateur($utilisateur);
               $em->persist($entity);
               $em->flush();
               return $this->redirect($this->generateUrl('boutique_panier_livraison'));
           }
       }

        return $this->render('boutique/panier/livraison.html.twig', array(
          'form' => $form->createView(),
          'utilisateur' => $utilisateur
        ));
    }

    public function setLivraisonOnSession(Request $request)
    {
        $session = $request->getSession();

        if (!$session->has('adresse')) $session->set('adresse',array());
        $adresse = $session->get('adresse');

        if ($request->request->get('livraison') != null && $request->request->get('facturation') != null)
        {
            $adresse['livraison'] = $request->request->get('livraison');
            $adresse['facturation'] = $request->request->get('facturation');
        } else {
            return $this->redirect($this->generateUrl('boutique_panier_validation'));
        }

        $session->set('adresse',$adresse);

        return $this->redirect($this->generateUrl('boutique_panier_validation'));
    }

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

    public function validationAction(Request $request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();

        if ($request->getMethod() == 'POST')
        {
            $this->setLivraisonOnSession($request);
        }

        //$prepareCommande = $this->forward('App\Controller\Ecommerce\CommandesController::prepareCommande');
        //$commande = $em->getRepository('App:Ecommerce\Commandes')->find($prepareCommande->getContent());

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

        return $this->render('boutique/panier/validation.html.twig', array(
            'commande' => $commande,
        ));
    }
}
