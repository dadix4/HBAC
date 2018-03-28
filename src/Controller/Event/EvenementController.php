<?php

namespace App\Controller\Event;

use App\Entity\Event\Evenement;
use App\Entity\Event\Reservation;
use App\Entity\Utilisateurs\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Evenement controller.
 *
 */
class EvenementController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $evenements = $em->getRepository('App:Event\Evenement')->allEvents();

        $events = [];
        foreach ($evenements as $evenement) {
            $event = $em->getRepository('App:Event\Evenement')->find($evenement);
            $idEvent = $event->getId();
            $nbInscrit = $em->getRepository('App:Event\Inscrit')->getNbinscrit($idEvent);

            $events[] =[
                'nbInscrit' => $nbInscrit,
                'evenement' => $event,
            ];
        }

        return $this->render('event/evenement/index.html.twig', array(
            'evenements' => $evenements,
             'events' => $events
        ));
    }


    public function reservationAction(Request $request ,Evenement $evenement)
    {
        //On recupere le mail de la personne qui reserve
        $user = $this->getUser();
        $userMail=$user->getEmail();

        $entityManager = $this->getDoctrine()->getManager();
        $tarifs = $entityManager->getRepository('App:Event\Tarif')->getNbtarif($evenement);

        $reservation = new Reservation();
        $form = $this->createForm('App\Form\Event\ReservationType', $reservation,array(
            'entity_manager' => $entityManager,
            'evenement' => $evenement->getId(),
        ));
        $form->handleRequest($request);

        //on controle si une reservation n'a pas déjà été faite.
        $checkmail = $entityManager->getRepository('App:Event\Reservation')
            ->findOneBy(array(
                'evenement' => $evenement,
                'mailReservation' => $userMail
            ));

        if ($form->isSubmitted() && $form->isValid()) {
            if(!is_object($checkmail)) {

                $reservation->setEvenement($evenement);
                $reservation->setMailReservation($userMail);
                $entityManager->persist($reservation);
                $entityManager->flush();

                if ($evenement->getGratuit() == 0) {
                    //on return sur la page de la validation pour le paiement
                    return $this->redirect($this->generateUrl('event_validation', array('id' => $evenement->getId(), 'reservation' => $reservation->getId())));
                } else {
                    //on return juste un mail de confirmation
                    $response = $this->forward('App\Controller\Event\EvenementController::notification', array(
                        'evenement'  => $evenement,
                        'reservation' => $reservation,
                        'user' => $user
                    ));

                    return $response;
                }
            }
            else{
                $request->getSession()->getFlashBag()->add('warning', "Une réservation avec l'adresse $userMail à déjà été effectuée pour cet évènement");
                return $this->redirect($this->generateUrl('event_reservation', array('id' => $evenement->getId())));
            }
        }

        return $this->render('event/evenement/reservation.html.twig', array(
            'form' => $form->createView(),
            'evenement' => $evenement,
            'tarifs' => $tarifs

        ));
    }


    public function notification(Request $request, Evenement $evenement, User $user ,Reservation $reservation, \Swift_Mailer $mailer)
    {
        //Information pour le mail de confirmation
        $notificationmail = $evenement->getMailNotification();
        $titre = $evenement->getTitre();
        $userMail=$user->getEmail();

        //Message de confirmation envoyé à l'inscrit
        $message = (new \Swift_Message())
            ->setSubject("Inscription : $titre")
            ->setFrom(array('webmaster@hbaclub.fr' => 'HBAC Sainte-Pazanne'))
            ->setTo($reservation->getMailReservation())
            ->setContentType('text/html')
            ->setBody(
                $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                    'event/email/registration.html.twig',
                    array(
                        'name' => $reservation->getCreatedBy()->getUsername(),
                        'titre' => $evenement->getTitre(),
                        'bodyMail' => $evenement->getBodyMail(),
                        'nomreservation' => $reservation->getNomReservation(),
                        'evenement' => $evenement,
                        'reservation' => $reservation,
                    )
                ),
                'text/html'
            );
        $mailer->send($message);

        //Message de notification envoyé à la personne qui gère l'évènement.
        $notification = (new \Swift_Message())
            ->setSubject("Notification Inscription : $titre")
            ->setFrom(array('webmaster@hbaclub.fr' => 'HBAC Sainte-Pazanne'))
            ->setTo(array("$notificationmail", 'webmaster@hbaclub.fr' => 'Notification HBAC'))
            ->setContentType('text/html')
            ->setBody(
                $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                    'event/email/notification.html.twig',
                    array(
                        'name' => $reservation->getCreatedBy()->getUsername(),
                        'titre' => $evenement->getTitre(),
                        'bodyMail' => $evenement->getBodyMail(),
                        'nomreservation' => $reservation->getNomReservation(),
                        'evenement' => $evenement,
                        'reservation' => $reservation,
                    )
                ),
                'text/html'
            );
        $mailer->send($notification);

        $request->getSession()->getFlashBag()->add('success', "Votre reservation à bien été enregistré. Un mail de confirmation vous a été envoyé à l'adresse $userMail ");
        return $this->redirect($this->generateUrl('event_index'));
    }


    public function validationAction(Evenement $evenement, Reservation $reservation)
    {
        $em = $this->getDoctrine()->getManager();

        //calcule du tarif de la reservation
        $inscritsTarifs = $em->getRepository('App:Event\Inscrit')->findByReservation($reservation);
        $totalTarif = 0;
        foreach ($inscritsTarifs as $inscritTarif){
            $tarif = $inscritTarif->getTarif()->getPrix();
            $totalTarif += round($tarif);
        }

        return $this->render('event/evenement/validation.html.twig', array(
            'reservation' => $reservation,
            'totalTarif' => $totalTarif,
            'evenement' => $evenement,
        ));
    }

    public function paiementAction(Evenement $evenement, Reservation $reservation)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $userMail=$user->getEmail();

        //calcule du tarif de la reservation
        $inscritsTarifs = $em->getRepository('App:Event\Inscrit')->findByReservation($reservation);
        $totalTarif = 0;
        foreach ($inscritsTarifs as $inscritTarif){
            $tarif = $inscritTarif->getTarif()->getPrix();
            $totalTarif += round($tarif);
        }

        \Stripe\Stripe::setApiKey("sk_test_bhNkc0yIrYNbdaIJbyYWkuhV");
        $token = $_POST['stripeToken'];

        //si le client n'a jamais fais d'achat la valeur "Client stripe" est vide donc on enregistre un nouveau client.
        //Sinon on le met à jour.
        if ( empty($clientStripe = $user->getIdStripe())) {
            $customer = \Stripe\Customer::create(array(
                'email' => $user->getEmailCanonical(),
                'card' => $token,
                'metadata' => array(

                )));
        } else {
            $customer = \Stripe\Customer::retrieve($clientStripe);
        }
        // Charge the user's card:
        $charge = \Stripe\Charge::create(array(
            "amount" => $totalTarif * 100,
            "currency" => "eur",
            "description" => "Evenement Hbaclub.fr",
            "statement_descriptor" => $evenement->getTitre(),
            "customer" => $customer->id,
        ));

        $user->setIdStripe($customer->id);
        $reservation->setStatutPaiement(1);
        $reservation->setDatePaiement(new \DateTime());
        $em->flush();

        $response = $this->forward('App\Controller\Event\EvenementController::notification', array(
            'evenement'  => $evenement,
            'reservation' => $reservation,
            'user' => $user
        ));

        return $response;
    }
}