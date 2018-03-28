<?php

namespace App\Controller\Match;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Match controller.
 *
 */
class MatchController extends Controller
{


    public function lastWeek()
    {
        //on recherche la semaine en cour pour afficher les resultats
        $now =  new \DateTime();
        $W = $now->format('W')-1; $Y = $now->format('Y');
        $lastSemaine = $Y."-".$W;

        return $lastSemaine;
    }
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $matchs = $em->getRepository('App:Match\Match')->getMatchs();
        $resultats = $em->getRepository('App:Match\Match')->getResultats($this->lastWeek());

        return $this->render('match/index.html.twig', array(
            'matchs' => $matchs,
            'resultats' => $resultats
        ));
    }


    /**
     * Affichage des résultats sur la page d'accueil.
     *
     */
    public function sidebarResultatAction()
    {
        $em = $this->getDoctrine()->getManager();
        $resultats = $em->getRepository('App:Match\Match')->getResultats($this->lastWeek());

        return $this->render('blog/sidebar/resultat.html.twig', array(
            'resultats' => $resultats
        ));
    }
}