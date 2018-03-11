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
        $form = $this->createForm('App\Form\Core\FicheMembreType', $fichebureau);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($fichebureau);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', "La fiche bureau a bien été créée");
            return $this->redirectToRoute('admin_bureau_index');
        }

        return $this->render('admin/core/bureau/index.html.twig', array(
            'fichesbureau' => $fichesbureau,
            'form' => $form->createView(),
        ));
    }

}

