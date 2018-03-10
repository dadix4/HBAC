<?php

namespace App\Controller\Admin\Core;

use App\Entity\Core\Licencie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Licencie controller.
 *
 */
class LicencieController extends Controller
{
    /**
     * Lists all licencie entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $licencies = $em->getRepository('App:Core\Licencie')->findAll();

        return $this->render('admin/core/licencie/index.html.twig', array(
            'licencies' => $licencies,
        ));
    }

    /**
     * Creates a new licencie entity.
     *
     */
    public function newAction(Request $request)
    {
        $licencie = new Licencie();
        $form = $this->createForm('App\Form\Core\LicencieType', $licencie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($licencie);
            $em->flush();

            return $this->redirectToRoute('admin_core_licencie_show', array('id' => $licencie->getId()));
        }

        return $this->render('admin/core/licencie/new.html.twig', array(
            'licencie' => $licencie,
            'form' => $form->createView(),
        ));
    }


    /**
     * Finds and displays a licencie entity.
     *
     */
    public function showAction(Licencie $licencie)
    {
        $deleteForm = $this->createDeleteForm($licencie);

        return $this->render('admin/core/licencie/show.html.twig', array(
            'licencie' => $licencie,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing licencie entity.
     *
     */
    public function editAction(Request $request, Licencie $licencie)
    {
        $deleteForm = $this->createDeleteForm($licencie);
        $editForm = $this->createForm('App\Form\Core\LicencieType', $licencie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_core_licencie_edit', array('id' => $licencie->getId()));
        }

        return $this->render('admin/core/licencie/edit.html.twig', array(
            'licencie' => $licencie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a licencie entity.
     *
     */
    public function deleteAction(Request $request, Licencie $licencie)
    {
        $form = $this->createDeleteForm($licencie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($licencie);
            $em->flush();
        }

        return $this->redirectToRoute('admin_core_licencie_index');
    }

    /**
     * Creates a form to delete a licencie entity.
     *
     * @param Licencie $licencie The licencie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Licencie $licencie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_core_licencie_delete', array('id' => $licencie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
