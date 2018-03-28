<?php

namespace App\Controller\Equipe;

use App\Entity\Equipe\Equipe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class TeamController extends Controller
{
    public function menuAction()
    {
        $em = $this->getDoctrine()->getManager();
        $saisons = $em->getRepository('App:Core\Saison')->getSaisonWithEquipeCategory();

        return $this->render('equipe/sidebar/menu.html.twig', array(
            'saisons' => $saisons,
        ));
    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $equipes = $em->getRepository('App:Equipe\Equipe')->findAll();

        return $this->render('equipe/index.html.twig', array(
            'equipes' => $equipes,
        ));
    }

    public function viewAction(Equipe $equipe)
    {
        return $this->render('equipe/view.html.twig', array(
            'equipe' => $equipe,
        ));
    }
}