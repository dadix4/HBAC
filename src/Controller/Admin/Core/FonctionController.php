<?php

namespace App\Controller\Admin\Core;

use App\Entity\Core\Bureau\Fonction;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Bureau controller.
 *
 */
class FonctionController extends Controller
{

    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $fonctions = $em->getRepository('App:Core\Bureau\Fonction')->findBy(array(), array('hierarchie'=>'asc'));


        $fonction = new Fonction();
        $form = $this->createForm('App\Form\Core\FonctionType', $fonction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($fonction);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'La fonction a bien été enregistrée');
            return $this->redirect($this->generateUrl('admin_fonction_index'));
        }

        return $this->render('admin/core/bureau/fonction.html.twig', array(
            'form' => $form->createView(),
            'fonctions' => $fonctions
        ));

    }

    public function editAction(Request $request, Fonction $fonction)
    {
        $em = $this->getDoctrine()->getManager();
        $fonctions = $em->getRepository('App:Core\Bureau\Fonction')->findBy(array(), array('hierarchie'=>'asc'));

        $form = $this->createForm('App\Form\Core\FonctionType', $fonction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($fonction);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'La fonction a bien été modifié');
            return $this->redirect($this->generateUrl('admin_fonction_index'));
        }

        return $this->render('admin/core/bureau/fonction.html.twig', array(
            'form' => $form->createView(),
            'fonctions' => $fonctions,
            'fonction' => $fonction
        ));

    }

    /**
     * Deletes a Fonction entity.
     *
     */
    public function deleteAction(Request $request, Fonction $fonction)
    {
        $form = $this->createDeleteForm($fonction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($fonction);
            $em->flush();
        }
        $request->getSession()->getFlashBag()->add('success', "Le fonction ". $fonction->getFonction() ."  a été supprimé" );
        return $this->redirectToRoute('admin_fonction_index');
    }

    /**
     * Creates a form to delete a ficheBureau entity.
     *
     * @param Fonction $saison The saison entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Fonction $fonction)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_club_delete', array('id' => $fonction->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

}