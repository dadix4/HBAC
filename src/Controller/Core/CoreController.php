<?php

namespace App\Controller\Core;

use App\Entity\Core\Contact;
use App\Entity\Core\Licencie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class CoreController extends Controller
{
    public function inscriptionAction()
    {
        return $this->render('core/site-frontend/inscription.html.twig', array(

        ));
    }

    public function entrainementAction()
    {
        $em = $this->getDoctrine()->getManager();
        // Affichage de tous les entrainements de la saison ACTIVE
        $entrainements = $em->getRepository('App:Core\Entrainement')->byActiveSaison();
        // On recherche la dernière mise à jour des entrainement
        $updateTraining = $em->getRepository('App:Core\Entrainement')->findUpdate();

        return $this->render('core/site-frontend/entrainement.html.twig', array(
            'entrainements' => $entrainements,
            'updateTraining' => $updateTraining
        ));
    }

    public function liensUtilesAction()
    {
        return $this->render('core/site-frontend/liensUtiles.html.twig', array(

        ));
    }

    public function sponsorsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $allSponsors = $em->getRepository('App:Core\Sponsors\Sponsors')->findAll();

        return $this->render('core/site-frontend/sponsors.html.twig', array(
            'allSponsors' => $allSponsors,
        ));
    }

    public function contactAction(Request $request, \Swift_Mailer $mailer)
    {
        $em = $this->getDoctrine()->getManager();
        $mail = new Contact();
        $form = $this->createForm('App\Form\Core\ContactType', $mail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mail->setDestinataire('Webmail Club');
            $em->persist($mail);
            $em->flush();

            $message = (new \Swift_Message())
                ->setSubject($form->get('sujet')->getData())
                ->setFrom($form->get('email')->getData())
                ->setTo('communication@hbaclub.fr')
                ->setContentType('text/html')
                ->setBody(
                    $this->renderView('core/site-frontend/contact/mailContact.html.twig', array(
                            'nom' => $form->get('nom')->getData(),
                            'prenom' => $form->get('prenom')->getData(),
                            'message' => $form->get('message')->getData() )),'text/html');
            $mailer->send($message);

            $this->get('session')->getFlashBag()->add('success', "Votre message à bien été envoyé. Merci. Nous vous répondrons dans les plus bref délais.");
            return $this->redirectToRoute('core_contact');
        }

        return $this->render('core/site-frontend/contact/contact.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function contactMembreAction(Request $request, \Swift_Mailer $mailer, Licencie $licencie)
    {
        $em = $this->getDoctrine()->getManager();
        $mail = new Contact();
        $form = $this->createForm('App\Form\Core\ContactType', $mail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mail->setDestinataire($licencie->getPrenomNom());
            $em->persist($mail);
            $em->flush();

            $message = (new \Swift_Message())
                ->setSubject($form->get('sujet')->getData())
                ->setFrom($form->get('email')->getData())
                ->setTo($licencie->getMail())
                ->setContentType('text/html')
                ->setBody(
                    $this->renderView('core/site-frontend/contact/mailContact.html.twig', array(
                        'nom' => $form->get('nom')->getData(),
                        'prenom' => $form->get('prenom')->getData(),
                        'message' => $form->get('message')->getData() )),'text/html');
            $mailer->send($message);

            $this->get('session')->getFlashBag()->add('success', "Votre message à bien été envoyé. Merci. Nous vous répondrons dans les plus bref délais.");
            return $this->redirectToRoute('index_bureau');
        }

        return $this->render('core/site-frontend/contact/contactMembre.html.twig', array(
            'form' => $form->createView(),
            'licencie' => $licencie
        ));
    }

}