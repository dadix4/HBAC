<?php

namespace App\Controller\Admin\Equipe;

use App\Entity\Core\Saison;
use App\Entity\Equipe\Equipe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Equipe controller.
 *
 */
class EquipeController extends Controller
{
    /**
     * Lists all equipe entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $equipes = $em->getRepository('App:Equipe\Equipe')->byActiveSaison();
        $saison = $em->getRepository('App:Core\Saison')->findOneBy(array('active' => true));

        return $this->render('admin/equipe/equipe/index.html.twig', array(
            'equipes' => $equipes,
            'saison' => $saison
        ));
    }

    public function equipeBySaisonAction(Saison $saison)
    {
        $em = $this->getDoctrine()->getManager();
        $equipes = $em->getRepository('App:Equipe\Equipe')->bySaison($saison);

        return $this->render('admin/equipe/equipe/index.html.twig', array(
            'equipes' => $equipes,
            'saison' => $saison
        ));
    }

    public function selectSaisonAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //form select saison, permet de choisir une saison pour ajouter une equipe.
        $form = $this->createForm('App\Form\Core\SelectSaisonType');
        $form->handleRequest($request);

        if ($request->request->has('add'))
        {
            if ($form->isSubmitted() && $form->isValid()) {
                $nomSaison = $form['nomSaison']->getData();//On récupère la saison selectionnée
                $saison = $em->getRepository('App:Core\Saison')->find($nomSaison->getId());
                return $this->redirectToRoute('admin_equipe_new', array('id'=>$saison->getId() ,'slug'=>$saison->getSlug()));
            }
        }
        if ($request->request->has('view'))
        {
            if ($form->isSubmitted() && $form->isValid()) {
                $nomSaison = $form['nomSaison']->getData();//On récupère la saison selectionnée
                $saison = $em->getRepository('App:Core\Saison')->find($nomSaison->getId());
                return $this->redirectToRoute('admin_equipe_bySaison', array('id'=>$saison->getId(),'slug'=>$saison->getSlug()));
            }
        }

        return $this->render('admin/equipe/equipe/selectSaison.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new equipe entity.
     *
     */
    public function newAction(Request $request, Saison $saison)
    {
        $equipe = new Equipe();
        $form = $this->createForm('App\Form\Equipe\EquipeType', $equipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $equipe->setSaison($saison);//relation manytoone avec saison, récupéré par le formulaire.
            $categorie = $form['categorie']->getData();//On récupère l'ID de categorie renseigner via le form equipe
            $nomEquipe = $categorie->getcategorieEquipe();// On affiche le nom de la catégorie
            $equipe->setNomEquipe($nomEquipe);// enregistrement dans l'équipe de la catégorie.
            $em->persist($equipe);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', "La création de l'équipe a bien été effectuée");
            return $this->redirectToRoute('admin_equipe_index', array('id'=>$saison->getId(), 'slug'=>$saison->getSlug()));
        }

        return $this->render('admin/equipe/equipe/new.html.twig', array(
            'equipe' => $equipe,
            'saison' => $saison,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a equipe entity.
     *
     */
    public function showAction(Equipe $equipe)
    {
        $deleteForm = $this->createDeleteForm($equipe);

        return $this->render('admin/equipe/equipe/show.html.twig', array(
            'equipe' => $equipe,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing equipe entity.
     *
     */
    public function editAction(Request $request, Equipe $equipe, Saison $saison)
    {
        $deleteForm = $this->createDeleteForm($equipe);
        $editForm = $this->createForm('App\Form\Equipe\EquipeEditType', $equipe);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->get('session')->getFlashBag()->add('success', "Modification de l'équipe effectuée");
            return $this->redirectToRoute('admin_equipe_bySaison', array('id'=>$saison->getId(),'slug'=>$saison->getSlug()));
        }
        return $this->render('admin/equipe/equipe/edit.html.twig', array(
            'equipe' => $equipe,
            'saison' => $saison,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a equipe entity.
     *
     */
    public function deleteAction(Request $request, Equipe $equipe, Saison $saison)
    {
        $form = $this->createDeleteForm($equipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($equipe);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', "La suppression de l'équipe a bien été effectuée");
        }
        else{
            $this->get('session')->getFlashBag()->add('error',  "Erreur lors de la suppression de l'équipe" );
        }

        return $this->redirectToRoute('admin_equipe_bySaison', array('id'=>$saison->getId(),'slug'=>$saison->getSlug()));
    }

    /**
     * Creates a form to delete a equipe entity.
     *
     * @param Equipe $equipe The equipe entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Equipe $equipe)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_equipe_delete', array('id' => $equipe->getId(), 'saison'=> $equipe->getSaison()->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
