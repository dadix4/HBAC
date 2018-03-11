<?php

namespace App\Controller\Admin\Core;

use App\Entity\Core\Bureau\FicheBureau;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Bureau controller.
 *
 */
class BureauController extends Controller
{
    /**
     * Lists all Bureau with form entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $fichesbureau = $em->getRepository('App:Core\Bureau\FicheBureau')->findBy(array(), array('createdAt'=>'desc'));

        $fichebureau = new FicheBureau();
        $form = $this->createForm('App\Form\Core\FicheBureauType', $fichebureau);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($fichebureau);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', "Le membre ". $fichebureau->getLicencies()->getPrenom() ." ". $fichebureau->getLicencies()->getNom()." a été rajouté à l'organigramme de la saison ". $fichebureau->getSaison()->getNomSaison());
            return $this->redirectToRoute('admin_bureau_index');
        }

        return $this->render('admin/core/bureau/index.html.twig', array(
            'fichesbureau' => $fichesbureau,
            'form' => $form->createView(),
        ));
    }

    /**
     * Lists all Bureau with form entities.
     *
     */
    public function editAction(Request $request, FicheBureau $fichebureau)
    {
        $em = $this->getDoctrine()->getManager();
        $fichesbureau = $em->getRepository('App:Core\Bureau\FicheBureau')->findBy(array(), array('createdAt'=>'desc'));

        $form = $this->createForm('App\Form\Core\FicheBureauType', $fichebureau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($fichebureau);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', "Le membre ". $fichebureau->getLicencies()->getPrenom() ." ". $fichebureau->getLicencies()->getNom()." a été modifié." );
            return $this->redirectToRoute('admin_bureau_index');
        }

        return $this->render('admin/core/bureau/index.html.twig', array(
            'fichesbureau' => $fichesbureau,
            'fichebureau' => $fichebureau,
            'form' => $form->createView(),
        ));
    }

    /**
     * Deletes a categorie entity.
     *
     */
    public function deleteAction(Request $request, FicheBureau $fichebureau)
    {
        $form = $this->createDeleteForm($fichebureau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($fichebureau);
            $em->flush();
        }
        $request->getSession()->getFlashBag()->add('success', "Le membre ". $fichebureau->getLicencies()->getPrenom() ." ". $fichebureau->getLicencies()->getNom()." a été supprimé de l'organigramme de la saison ". $fichebureau->getSaison()->getNomSaison());
        return $this->redirectToRoute('admin_bureau_index');
    }

    /**
     * Creates a form to delete a ficheBureau entity.
     *
     * @param FicheBureau $saison The saison entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FicheBureau $fichebureau)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_club_delete', array('id' => $fichebureau->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }


}

