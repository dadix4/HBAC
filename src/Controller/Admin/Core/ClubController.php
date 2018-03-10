<?php

namespace App\Controller\Admin\Core;

use App\Entity\Core\Club;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Club controller.
 *
 */
class ClubController extends Controller
{
    public function clubsAction()
    {
        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();
        // Pour récupérer mon club
        $monClub = $em->getRepository('App:Core\Club')->getMonClub();
        // Pour récupérer mon club
        $clubConvention = $em->getRepository('App:Core\Club')->getConventionClub();
        // Pour récupérer toutes les rencontres à venir
        $listclubs = $em->getRepository('App:Core\Club')->findAllClubs();


        // Puis modifiez la ligne du render comme ceci, pour prendre en compte les variables :
        return $this->render('admin/core/club/index.html.twig', array(
            'listclubs' => $listclubs,
            'monClub' => $monClub,
            'clubConvention' => $clubConvention
        ));
    }

    public function addClubAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // On crée un objet Equipe
        $new_club = new Club();

        $form = $this->createForm('App\Form\Core\ClubType', $new_club);
        $form->handleRequest($request);
        //on controle si club ajouté existe déjà.
        $refclub = $form['numeroFederal']->getData();
        $nomclub = $form['nomClub']->getData();
        $checkrefclub = $em->getRepository('App:Core\Club')
            ->findOneByNumeroFederal($refclub);

        if ($form->isValid()) {
            if (!is_object($checkrefclub)) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($new_club);
                $em->flush();
                $request->getSession()->getFlashBag()->add('success', 'Nouveau $checkrefclub club enregistré.');
                return $this->redirect($this->generateUrl('admin_club_index'));
            } else {
                $request->getSession()->getFlashBag()->add('error', "Le club : " . $nomclub . " est déjà enregistré en base de donnée. Merci de faire une recherche du Numéro Fédéral dans le tableau.");
                return $this->redirect($this->generateUrl('admin_club_index'));
            }
        }

        return $this->render('admin/core/club/addClub.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function editClubAction(Request $request, Club $club)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm('App\Form\Core\ClubType', $club);
        $form->handleRequest($request);

        //on controle si club ajouté existe déjà.
        $refclub = $form['numeroFederal']->getData();
        $nomclub = $form['nomClub']->getData();
        $checkrefclub = $em->getRepository('App:Core\Club')
            ->findOneByNumeroFederal($refclub);

        if ($form->isSubmitted() && $form->isValid()) {
                $em->flush();
                $request->getSession()->getFlashBag()->add('success', 'modification du club enregistré.');
                return $this->redirect($this->generateUrl('admin_club_index'));
        }

        return $this->render('admin/core/club/editClub.html.twig', array(
            'form' => $form->createView(),
            'club' => $club
        ));
    }

    /**
     * Deletes a categorie entity.
     *
     */
    public function deleteAction(Request $request, Club $club)
    {
        $form = $this->createDeleteForm($club);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($club);
            $em->flush();
        }
        $request->getSession()->getFlashBag()->add('success', 'Suppression effectuée du club');
        return $this->redirectToRoute('admin_club_index');
    }

    /**
     * Creates a form to delete a categorie entity.
     *
     * @param Club $saison The saison entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Club $club)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_club_delete', array('id' => $club->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

}
