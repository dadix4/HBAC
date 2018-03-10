<?php

namespace App\Controller\Admin\Utilisateurs;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UtilisateursAdminController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $utilisateurs = $em->getRepository('App:Utilisateurs\User')->findAll();

        return $this->render('admin/utilisateurs/index.html.twig', array('utilisateurs' => $utilisateurs));
    }

    public function utilisateurAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $utilisateur = $em->getRepository('App:Utilisateurs\User')->find($id);
        $route = $request->get('_route');

        if ($route == 'admin_utilisateurs_adresses')
        {
            return $this->render('admin/utilisateurs/adresses.html.twig', array('utilisateur' => $utilisateur));
        }
        elseif ($route == 'admin_utilisateurs_commandes')
        {
            return $this->render('admin/utilisateurs/commandes.html.twig', array('utilisateur' => $utilisateur));
        } else
        {
            throw $this->createNotFoundException('La vue n\'existe pas !');
        }
    }
}
