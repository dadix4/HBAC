<?php

namespace App\Controller\Admin\Event;

use App\Entity\Event\Evenement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Evenement controller.
 *
 */
class EvenementController extends Controller
{
    /**
     * Lists all evenement entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $evenements = $em->getRepository('App:Event\Evenement')->findAll();

        $events = [];
        foreach ($evenements as $evenement) {
            $event = $em->getRepository('App:Event\Evenement')->find($evenement);
            $idEvent = $event->getId();
            $nbInscrit = $em->getRepository('App:Event\Inscrit')->getNbinscrit($idEvent);
            $TTtarif = $em->getRepository('App:Event\Inscrit')->getTarifByEvent($idEvent);

            $events[] =[
                'nbInscrit' => $nbInscrit,
                'evenement' => $event,
                'TTtarif' => $TTtarif
            ];
           }

        return $this->render('admin/event/evenement/index.html.twig', array(
            'evenements' => $evenements,
            'events' => $events
        ));
    }

    /**
     * Creates a new evenement entity.
     *
     */
    public function newAction(Request $request)
    {
        $evenement = new Evenement();
        $form = $this->createForm('App\Form\Event\EvenementType', $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();

            return $this->redirectToRoute('admin_event_index');
        }

        return $this->render('admin/event/evenement/new.html.twig', array(
            'evenement' => $evenement,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing evenement entity.
     *
     */
    public function editAction(Request $request, Evenement $evenement)
    {
        $deleteForm = $this->createDeleteForm($evenement);
        $form = $this->createForm('App\Form\Event\EvenementType', $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_event_index');
        }

        return $this->render('admin/event/evenement/edit.html.twig', array(
            'evenement' => $evenement,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a evenement entity.
     *
     */
    public function deleteAction(Request $request, Evenement $evenement)
    {
        $form = $this->createDeleteForm($evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($evenement);
            $em->flush();
        }

        return $this->redirectToRoute('admin_event_index');
    }

    /**
     * Creates a form to delete a evenement entity.
     *
     * @param Evenement $evenement The evenement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Evenement $evenement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_event_delete', array('id' => $evenement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
