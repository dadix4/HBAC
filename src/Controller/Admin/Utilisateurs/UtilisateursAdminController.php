<?php

namespace App\Controller\Admin\Utilisateurs;

use App\Entity\Utilisateurs\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Spipu\Html2Pdf\Tag\Html\U;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UtilisateursAdminController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $utilisateurs = $em->getRepository('App:Utilisateurs\User')->findAll();

        return $this->render('admin/utilisateurs/index.html.twig', array('utilisateurs' => $utilisateurs));
    }

    public function utilisateurAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $utilisateur = $em->getRepository('App:Utilisateurs\User')->find($id);
        $route = $request->get('_route');

        if ($route == 'admin_utilisateurs_adresses')
        {
            return $this->render('admin/utilisateurs/adresses.html.twig', array('utilisateur' => $utilisateur));
        }
        elseif ($route == 'admin_utilisateurs_commandes')
        {
            return $this->render('admin/utilisateurs/commandes.html.twig', array('utilisateur' => $utilisateur));
        } else
        {
            throw $this->createNotFoundException('La vue n\'existe pas !');
        }
    }

    public function usersAction($limit = 20)
    {
        $users = $this->getDoctrine()
            ->getManager()
            ->getRepository('App:Utilisateurs\User')
            ->findAll(
                array(),                 // Pas de critère
                array('username' => 'DESC'), // On trie de Z a A les equipes (ASC pour de A a Z)
                $limit,                  // On sélectionne $limit annonces
                0                        // À partir du premier
            );

        return $this->render('admin/utilisateurs/users.html.twig', array(
            'users' => $users,
        ));
    }

    public function editAction(Request $request, User $user)
    {
        $editForm = $this->createForm('App\Form\Utilisateurs\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->get('session')->getFlashBag()->add('success', "Modification de l'utilisateur effectué");
            return $this->redirectToRoute('admin_user_index');
        }
        return $this->render('admin/utilisateurs/editUser.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     *
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($user);
            $em->flush();
        }
        $request->getSession()->getFlashBag()->add('success', "Suppression de l'utilisateur effectuée");
        return $this->redirectToRoute('admin_user_index');
    }

    /**
     * Creates a form to delete a categorie entity.
     *
     * @param User $salle The saison entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_salle_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }


}
