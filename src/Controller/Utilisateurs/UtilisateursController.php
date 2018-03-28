<?php

namespace App\Controller\Utilisateurs;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UtilisateursController extends Controller
{

    public function villesAction(Request $request, $cp)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $villesCP = $em->getRepository('App:VillesFrance')->byCodePostal($cp);

            if ($villesCP) {
                $villes = array();
                foreach ($villesCP as $ville) {
                    $villes[] = $ville->getVilleNomReel();
                }
            } else {
                $ville = null;
            }

            $response = new JsonResponse();
            return $response->setData(array('ville' => $villes));

        } else {
            throw new \Exception('Erreur');
        }

    }

    public function facturesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $utilisateur = $this->getUser(); // on recupère l'utilisateur co
        $factures = $em->getRepository('App:Ecommerce\Commandes')->byFacture($utilisateur);
        return $this->render('Utilisateurs/monCompte/facture.html.twig', array('factures' => $factures));
    }

    public function facturePDFAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $utilisateur = $this->getUser(); // on recupère l'utilisateur co
        $facture = $em->getRepository('App:Ecommerce\Commandes')->findOneBy(array('utilisateur' => $utilisateur,
            'valider' => 1,
            'id' => $id));
        if (!$facture) {
            $this->get('session')->getFlashBag()->add('error', 'Une erreur est survenue');
            return $this->redirect($this->generateUrl('user_mes_commandes'));
        }

        $this->container->get('setNewFacture')->facture($facture)->Output('facture.pdf');//le service facture

        $response = new Response();
        $response->headers->set('content-type', 'application/pdf');

        return $response;


    }
}
