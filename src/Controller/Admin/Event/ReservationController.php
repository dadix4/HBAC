<?php

namespace App\Controller\Admin\Event;

use App\Entity\Event\Evenement;
use App\Entity\Event\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Evenement controller.
 *
 */
class ReservationController extends Controller
{
    /**
     * Lists all reservation entities.
     *
     */
    public function indexAction(Evenement $evenement)
    {
        $em = $this->getDoctrine()->getManager();
        $reservations = $em->getRepository('App:Event\Reservation')->getRervationsByEvent($evenement);

        return $this->render('admin/event/reservation/index.html.twig', array(
            'reservations' => $reservations,
        ));
    }

    public function inscritsAction(Reservation $reservation)
    {
        $em = $this->getDoctrine()->getManager();
        $inscrits = $em->getRepository('App:Event\Inscrit')->findByReservation($reservation);

        return $this->render('admin/event/reservation/inscrit.html.twig', array(
            'inscrits' => $inscrits,
            'reservation' => $reservation
        ));
    }
}