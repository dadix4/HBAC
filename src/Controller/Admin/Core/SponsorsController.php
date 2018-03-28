<?php

namespace App\Controller\Admin\Core;

use App\Entity\Core\Sponsors\Sponsors;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Sponsors controller.
 *
 */
class SponsorsController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $listsponsors = $em->getRepository('App:Core\Sponsors\Sponsors')->findAll();

        $sponsors = new Sponsors();
        $form = $this->createForm('App\Form\Core\Sponsors\SponsorsType', $sponsors);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sponsors);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Le partenariat a bien été enregistré');
            return $this->redirect($this->generateUrl('admin_sponsors_index'));
        }

        return $this->render('admin/core/sponsors/index.html.twig', array(
            'form' => $form->createView(),
            'listsponsors' => $listsponsors
        ));
    }

    public function editAction(Request $request, Sponsors $sponsors)
    {
        $em = $this->getDoctrine()->getManager();
        $listsponsors = $em->getRepository('App:Core\Sponsors\Sponsors')->findAll();

        $form = $this->createForm('App\Form\Core\Sponsors\SponsorsType', $sponsors);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($sponsors);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Le partenariat a bien été modifié');
            return $this->redirect($this->generateUrl('admin_sponsors_index'));
        }

        return $this->render('admin/core/sponsors/index.html.twig', array(
            'form' => $form->createView(),
            'sponsors' => $sponsors,
            'listsponsors' => $listsponsors
        ));
    }

    /**
     * Deletes a Fonction entity.
     *
     */
    public function deleteAction(Request $request, Sponsors $sponsors)
    {
        $form = $this->createDeleteForm($sponsors);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($sponsors);
            $em->flush();
        }
        $request->getSession()->getFlashBag()->add('success', "Le partenariat ". $sponsors->getNom() ."  a été supprimé" );
        return $this->redirectToRoute('admin_sponsors_index');
    }

    /**
     * Creates a form to delete a ficheBureau entity.
     *
     * @param Sponsors $saison The saison entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Sponsors $sponsors)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_sponsors_delete', array('id' => $sponsors->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}