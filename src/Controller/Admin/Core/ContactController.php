<?php

namespace App\Controller\Admin\Core;

use App\Entity\Core\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Bureau controller.
 *
 */
class ContactController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $messages = $em->getRepository('App:Core\Contact')->findBy(array(), array('createdAt' => 'desc'));


        return $this->render('admin/core/contact/index.html.twig', array(
            'messages' => $messages,
        ));
    }

    /**
     * Deletes a categorie entity.
     *
     */
    public function deleteAction(Request $request, Contact $contact)
    {
        $form = $this->createDeleteForm($contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($contact);
            $em->flush();
        }
        $request->getSession()->getFlashBag()->add('success', 'Suppression effectuée du message');
        return $this->redirectToRoute('admin_contact_index');
    }

    /**
     * Creates a form to delete a Contact entity.
     *
     * @param Contact $saison The saison entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Contact $contact)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_contact_delete', array('id' => $contact->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}