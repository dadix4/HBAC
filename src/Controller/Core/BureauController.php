<?php

namespace App\Controller\Core;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class BureauController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $membres = $em->getRepository('App:Core\Bureau\FicheBureau')->getBureauWithActiveSaison();

        return $this->render('core/bureau/index.html.twig', array(
            'membres' => $membres,
        ));
    }
}