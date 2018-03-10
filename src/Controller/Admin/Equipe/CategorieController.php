<?php

namespace App\Controller\Admin\Equipe;

use App\Entity\Equipe\Categorie;
use App\Form\Equipe\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Equipe controller.
 *
 */
class CategorieController extends Controller
{
    /**
     * Lists all categorie entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('App:Equipe\Categorie')->byHierarchie();

        $categorie = new Categorie();
        $form=$this->createForm('App\Form\Equipe\CategorieType', $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($categorie);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', "La catégorie a bien été ajoutée");
            return $this->redirectToRoute('admin_equipe_categorie_index');
        }

        return $this->render('admin/equipe/categorie/index.html.twig', array(
            'categories' => $categories,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing equipe entity.
     *
     */
    public function editAction(Request $request, Categorie $categorie)
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('App:Equipe\Categorie')->byHierarchie();

        $form = $this->createForm('App\Form\Equipe\CategorieType', $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->get('session')->getFlashBag()->add('success', "Modification de la catégorie de l'équipe effectuée");
            return $this->redirectToRoute('admin_equipe_categorie_index');
        }

        return $this->render('admin/equipe/categorie/index.html.twig', array(
            'categories' => $categories,
            'form' => $form->createView(),
        ));
    }

    public function hierarchieAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('App:Equipe\Categorie')->byHierarchie();

        $data = ['categories' => $categories];
        $form = $this->createFormBuilder($data)
            ->add('categories', CollectionType::class, ['entry_type' => CategorieType::class])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Modification effectuée');
            return $this->redirect($this->generateUrl('admin_equipe_categorie_index'));
        }

        return $this->render('admin/equipe/categorie/hierarchie.html.twig', array(
            'form' => $form->createView(),
            'categories' => $categories
        ));
    }

    /**
     * Deletes a categorie entity.
     *
     */
    public function deleteAction(Request $request, Categorie $categorie)
    {
        $form = $this->createDeleteForm($categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($categorie);
            $em->flush();
        }
        $request->getSession()->getFlashBag()->add('success', 'Suppression effectuée');
        return $this->redirectToRoute('admin_equipe_categorie_index');
    }

    /**
     * Creates a form to delete a categorie entity.
     *
     * @param Categorie $categorie The categorie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Categorie $categorie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_equipe_categorie_delete', array('id' => $categorie->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}