<?php

namespace App\Controller\Admin\Core;

use App\Entity\Core\Salle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Salle controller.
 *
 */
class SalleController extends Controller
{
    /**
     * Lists all saison entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $salles = $em->getRepository('App:Core\Salle')->findAll();

        $salle = new Salle();
        $form = $this->createForm('App\Form\Core\SalleType', $salle);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($salle);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', "La salle a bien été ajoutée");
            return $this->redirectToRoute('admin_salle_index');
        }

        return $this->render('admin/core/salle/index.html.twig', array(
            'salles' => $salles,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing equipe entity.
     *
     */
    public function editAction(Request $request, Salle $salle)
    {
        $em = $this->getDoctrine()->getManager();
        $salles = $em->getRepository('App:Core\Salle')->findAll();

        $form = $this->createForm('App\Form\Core\SalleType', $salle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->get('session')->getFlashBag()->add('success', "Modification de la salle effectuée");
            return $this->redirectToRoute('admin_salle_index');
        }

        return $this->render('admin/core/salle/index.html.twig', array(
            'salles' => $salles,
            'form' => $form->createView(),
        ));
    }

    /**
     * Deletes a categorie entity.
     *
     */
    public function deleteAction(Request $request, Salle $salle)
    {
        $form = $this->createDeleteForm($salle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($salle);
            $em->flush();
        }
        $request->getSession()->getFlashBag()->add('success', 'Suppression effectuée');
        return $this->redirectToRoute('admin_salle_index');
    }

    /**
     * Creates a form to delete a categorie entity.
     *
     * @param Salle $salle The saison entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Salle $salle)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_salle_delete', array('id' => $salle->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}