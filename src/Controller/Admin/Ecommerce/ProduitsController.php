<?php

namespace App\Controller\Admin\Ecommerce;

use App\Entity\Ecommerce\Produits;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Produit controller.
 *
 */
class ProduitsController extends Controller
{


    /**
     * Lists all produit entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('App:Ecommerce\Produits')->findAll();


        return $this->render('admin/ecommerce/produits/index.html.twig', array(
            'produits' => $produits,
        ));
    }

    /**
     * Lists des produits supprimés
     *
     */
    public function softDelProduitAction()
    {
        $em = $this->getDoctrine()->getManager();
        $em->getFilters()->disable('softdeleteable');
        $produits = $em->getRepository('App:Ecommerce\Produits')->findByRemove();


        return $this->render('admin/ecommerce/produits/corbeilleProduit.html.twig', array(
            'produits' => $produits,
        ));
    }

    public function restoreAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getFilters()->disable('softdeleteable');

        $produit = $em->getRepository('App:Ecommerce\Produits')->find($id);
        $produit->setDeletedAt(null);
        $em->persist($produit);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success','Produit restauré avec succès !');

        return $this->redirectToRoute('admin_ecommerce_produits_corbeille');
    }

    /**
     * Creates a new produit entity.
     *
     */
    public function newAction(Request $request)
    {
        $produit = new Produits();
        $form = $this->createForm('App\Form\Ecommerce\produitsType', $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Article ajouté avec succès');

            return $this->redirectToRoute('admin_ecommerce_produits_show', array('id' => $produit->getId()));

        }

        return $this->render('admin/ecommerce/produits/new.html.twig', array(
            'produit' => $produit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a produit entity.
     *
     */
    public function showAction(produits $produit)
    {
        $deleteForm = $this->createDeleteForm($produit);

        return $this->render('admin/ecommerce/Produits/show.html.twig', array(
            'produit' => $produit,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing produit entity.
     *
     */
    public function editAction(Request $request, produits $produit)
    {
        $deleteForm = $this->createDeleteForm($produit);
        $editForm = $this->createForm('App\Form\Ecommerce\produitsEditType', $produit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em ->flush();
            $this->get('session')->getFlashBag()->add('success','Modification effectuée');

            return $this->redirectToRoute('admin_ecommerce_produits_edit', array('id' => $produit->getId()));

        }

        return $this->render('admin/ecommerce/produits/edit.html.twig', array(
            'produit' => $produit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a produit entity.
     *
     */
    public function deleteAction(Request $request, produits $produit)
    {
        $form = $this->createDeleteForm($produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($produit);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Article supprimé avec succès');
        }

        return $this->redirectToRoute('admin_ecommerce_produits_index');
    }

    /**
     * Creates a form to delete a produit entity.
     *
     * @param produits $produit The produit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Produits $produit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_ecommerce_produits_delete', array('id' => $produit->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
