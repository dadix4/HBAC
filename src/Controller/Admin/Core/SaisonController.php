<?php

namespace App\Controller\Admin\Core;

use App\Entity\Core\Saison;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Licencie controller.
 *
 */
class SaisonController extends Controller
{
    /**
     * Lists all saison entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $saisons = $em->getRepository('App:Core\Saison')->findAll();

        $saison = new Saison();
        $form=$this->createForm('App\Form\Core\SaisonType', $saison);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($saison);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', "La saison a bien été ajoutée");
            return $this->redirectToRoute('admin_saison_index');
        }

        return $this->render('admin/core/saison/index.html.twig', array(
            'saisons' => $saisons,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing equipe entity.
     *
     */
    public function editAction(Request $request, Saison $saison)
    {
        $em = $this->getDoctrine()->getManager();
        $saisons = $em->getRepository('App:Core\Saison')->findAll();

        $form = $this->createForm('App\Form\Core\SaisonType', $saison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->get('session')->getFlashBag()->add('success', "Modification de la saison effectuée");
            return $this->redirectToRoute('admin_saison_index');
        }

        return $this->render('admin/core/saison/index.html.twig', array(
            'saisons' => $saisons,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing equipe entity.
     *
     */
    public function activeAction(Saison $updateSaison)
    {
        $em = $this->getDoctrine()->getManager();
        $saisonActive = $em->getRepository('App:Core\Saison')->findByActive(true);

        if ($updateSaison->getActive() == false) {
            //on désactive la ou les saisons actuellement activées
            foreach ($saisonActive as $saison) {
                $saison->setActive(false);
            }
            //on active la saison
            $updateSaison->setActive(true);
            $this->get('session')->getFlashBag()->add('success', "Saison activée");

        } elseif ($updateSaison->getActive() == true) {
            $updateSaison->setActive(false);
            $this->get('session')->getFlashBag()->add('warning', "Pas de saison d'activée !");
        }

        $em->flush();
        return $this->redirectToRoute('admin_saison_index');
    }

    /**
     * Deletes a categorie entity.
     *
     */
    public function deleteAction(Request $request, Saison $saison)
    {
        $form = $this->createDeleteForm($saison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($saison);
            $em->flush();
        }
        $request->getSession()->getFlashBag()->add('success', 'Suppression effectuée');
        return $this->redirectToRoute('admin_saison_index');
    }

    /**
     * Creates a form to delete a categorie entity.
     *
     * @param Saison $saison The saison entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Saison $saison)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_saison_delete', array('id' => $saison->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}