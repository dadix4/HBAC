<?php

namespace App\Controller\Admin\Core;

use App\Entity\Core\Entrainement;
use App\Entity\Core\Saison;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Licencie controller.
 *
 */
class EntrainementController extends Controller
{
    /**
     * Lists all entrainement entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entrainements = $em->getRepository('App:Core\Entrainement')->byActiveSaison();
        $saison = $em->getRepository('App:Core\Saison')->findOneBy(array('active' => true));

        return $this->render('admin/core/entrainement/index.html.twig', array(
            'entrainements' => $entrainements,
            'saison' => $saison
        ));
    }

    public function entrainementBySaisonAction(Saison $saison)
    {
        $em = $this->getDoctrine()->getManager();
        $entrainements = $em->getRepository('App:Core\Entrainement')->bySaison($saison);

        return $this->render('admin/core/entrainement/index.html.twig', array(
            'entrainements' => $entrainements,
            'saison' => $saison
        ));
    }



    public function selectSaisonAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //form select saison, permet de choisir une saison pour ajouter un entrainement.
        $form = $this->createForm('App\Form\Core\SelectSaisonType');
        $form->handleRequest($request);

        if ($request->request->has('add'))
        {
            if ($form->isSubmitted() && $form->isValid()) {
                $nomSaison = $form['nomSaison']->getData();//On récupère la saison selectionnée
                $saison = $em->getRepository('App:Core\Saison')->find($nomSaison->getId());
                return $this->redirectToRoute('admin_entrainement_new', array('id'=>$saison->getId() ,'slug'=>$saison->getSlug()));
            }
        }
        if ($request->request->has('view'))
        {
            if ($form->isSubmitted() && $form->isValid()) {
                $nomSaison = $form['nomSaison']->getData();//On récupère la saison selectionnée
                $saison = $em->getRepository('App:Core\Saison')->find($nomSaison->getId());
                return $this->redirectToRoute('admin_entrainement_bySaison', array('id'=>$saison->getId(),'slug'=>$saison->getSlug()));
            }
        }

        return $this->render('admin/core/entrainement/selectSaison.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new entrainement entity.
     *
     */
    public function newAction(Request $request, Saison $saison)
    {
        $entrainement = new Entrainement();
        $form = $this->createForm('App\Form\Core\EntrainementType', $entrainement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entrainement->setSaison($saison);//relation manytoone avec saison, récupéré par le formulaire.
            $em->persist($entrainement);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', "Enregistrement du créneau d'entrainement effectué");
            return $this->redirectToRoute('admin_entrainement_bySaison', array('id'=>$saison->getId(), 'slug'=>$saison->getSlug()));
        }

        return $this->render('admin/core/entrainement/formEntrainement.html.twig', array(
            'entrainement' => $entrainement,
            'saison' => $saison,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing entrainement entity.
     *
     */
    public function editAction(Request $request, Entrainement $entrainement, Saison $saison)
    {
        $form = $this->createForm('App\Form\Core\EntrainementType', $entrainement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->get('session')->getFlashBag()->add('success', "Modification du créneau d'entrainement effectué");
            return $this->redirectToRoute('admin_entrainement_bySaison', array('id'=>$saison->getId(), 'slug'=>$saison->getSlug()));
        }

        return $this->render('admin/core/entrainement/editEntrainement.html.twig', array(
            'entrainement' => $entrainement,
            'saison' => $saison,
            'form' => $form->createView(),
        ));
    }

    /**
     * Deletes a entrainement entity.
     *
     */
    public function deleteAction(Request $request, Entrainement $entrainement, Saison $saison)
    {
        $form = $this->createDeleteForm($entrainement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($entrainement);
            $em->flush();
        }
        $request->getSession()->getFlashBag()->add('success', 'Suppression effectuée');
        return $this->redirectToRoute('admin_entrainement_bySaison', array('id'=>$saison->getId(),'slug'=>$saison->getSlug()));;
    }

    /**
     * Creates a form to delete a entrainement entity.
     *
     * @param Entrainement $entrainement The saison entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Entrainement $entrainement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_entrainement_delete', array('id' => $entrainement->getId(), 'saison'=> $entrainement->getSaison()->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}