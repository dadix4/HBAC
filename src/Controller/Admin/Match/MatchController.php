<?php

namespace App\Controller\Admin\Match;

use App\Entity\Match\Match;
use App\Form\Match\EditMatchsType;
use App\Form\Match\ScoresType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Match controller.
 *
 */
class MatchController extends Controller
{
    public function selectFormSemaineAction($semaine)
    {
        $em = $this->getDoctrine()->getManager();
        $semaines = $em->getRepository('App:Match\Match')->menuMatchs();

        return $this->render('admin/match/menu/selectSemaine.html.twig', array(
            'semaines' => $semaines,
            'semaine'  => $semaine
        ));
    }
    /**
     * Lists all match entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $now =  new \DateTime();
        $semaine= $now->format('Y-W');
        $matchs = $em->getRepository('App:Match\Match')->findBySemaine($semaine);

        return $this->render('admin/match/match/index.html.twig', array(
            'semaine' => $semaine,
            'matchs' => $matchs
        ));
    }

    /**
     * Lists all matchs by semaine
     *
     */
    public function matchsBySemaineAction($semaine)
    {
        $em = $this->getDoctrine()->getManager();

        $matchs = $em->getRepository('App:Match\Match')->findBySemaine($semaine);

        return $this->render('admin/match/match/index.html.twig', array(
            'semaine' => $semaine,
            'matchs' => $matchs
        ));
    }

    /**
     * Traitement du form select semaine
     *
     */
    public function formSelectMatchsAction(Request $request)
    {
        if ($request->request->has('add'))
        {
            $semaineSelected = $request->get('dateSemaine');
            return $this->redirect($this->generateUrl('admin_match_bysemaine', array('semaine'=>$semaineSelected)));
        }
        else {
            $this->get('session')->getFlashBag()->add('error', "Pas de match trouvé pour cette semaine");
            return $this->redirect($this->generateUrl('admin_match_index'));
        }
    }

    /**
    * Resultats des matchs
    *
    */
    public function scoresAction($semaine, Request $request)
    {
        // On récupère la liste des matchs
        $em = $this->getDoctrine()->getManager();

        //On recupère les matchs par rapport à la semaine.
        $matchs = $em->getRepository('App:Match\Match')->findBySemaine($semaine);

        $data = ['matchs' => $matchs];
        $form = $this->createFormBuilder($data)
            ->add('matchs', CollectionType::class, array('entry_type' => ScoresType::class))
            ->add('save', SubmitType::class, array('label' => 'Sauvegarder'))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Scores enregistrés');
            return $this->redirect($this->generateUrl('admin_match_bysemaine', array('semaine'=>$semaine)));
        }

        return $this->render('admin/match/match/scores.html.twig', array(
            'matchs' => $matchs,
            'form' => $form->createView(),
            'semaine' => $semaine
        ));
    }



    /**
     * Creates a new match entity.
     *
     */
    public function newAction(Request $request)
    {
        $match = new Match();
        $form = $this->createForm('App\Form\Match\MatchType', $match);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $date = $form['date']->getData();//On récupère la date renseigné via le form equipe
            $numReceveur = $form['numReceveur']->getData();
            $numVisiteur = $form['numVisiteur']->getData();
            $refPoule = $form['numPoule']->getData();

            $match->setSemaine($date->format('Y-W'));

            // Recherche et enregistrement d'une correspondance entre l'equipe local et la bibliotèque de club. Permet de récupérer logo.
            if ($searchcodefederallocal = $em->getRepository('App:Core\Club')->findOneByNumeroFederal($numReceveur)) {
            $match->setClubReceveur($searchcodefederallocal);};
            // Recherche et enregistrement d'une correspondance entre l'equipe visiteur et la bibliotèque de club. Permet de récupérer logo.
            if ($searchcodefederalvisiteur = $em->getRepository('App:Core\Club')->findOneByNumeroFederal($numVisiteur)) {
            $match->setClubVisiteur($searchcodefederalvisiteur);};

            // Recherche et enregistrement d'une correspondance entre une équipe et les references de competition
            $numPoules = $em->getRepository('App:Equipe\RefCompetition')->findByReference($refPoule);
            foreach ($numPoules as $numPoule){
                $equipe = $em->getRepository('App:Equipe\Equipe')->find($numPoule->getEquipe()->getId());
                $match->addEquipeMatch($equipe);
            }

            $em->persist($match);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Enregistrement de la Rencontre');
            return $this->redirect($this->generateUrl('admin_match_bysemaine', array('semaine'=>$date->format('Y-W'))));
        }

        return $this->render('admin/match/match/new.html.twig', array(
            'match' => $match,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a match entity.
     *
     */
    public function showAction(Match $match)
    {
        $deleteForm = $this->createDeleteForm($match);

        return $this->render('admin/match/match/show.html.twig', array(
            'match' => $match,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing match entity.
     *
     */
    public function editAction(Request $request, Match $match)
    {
        $deleteForm = $this->createDeleteForm($match);
        $editForm = $this->createForm('App\Form\Match\MatchType', $match);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $date = $editForm['date']->getData();//On récupère la date renseigné via le form equipe
            $numReceveur = $editForm['numReceveur']->getData();
            $numVisiteur = $editForm['numVisiteur']->getData();
            $refPoule = $editForm['numPoule']->getData();

            $match->setSemaine($date->format('Y-W'));

            // Recherche et enregistrement d'une correspondance entre l'equipe local et la bibliotèque de club. Permet de récupérer logo.
            if ($searchcodefederallocal = $em->getRepository('App:Core\Club')->findOneByNumeroFederal($numReceveur)) {
                $match->setClubReceveur($searchcodefederallocal);};
            // Recherche et enregistrement d'une correspondance entre l'equipe visiteur et la bibliotèque de club. Permet de récupérer logo.
            if ($searchcodefederalvisiteur = $em->getRepository('App:Core\Club')->findOneByNumeroFederal($numVisiteur)) {
                $match->setClubVisiteur($searchcodefederalvisiteur);};

            // Recherche et enregistrement d'une correspondance entre une équipe et les references de competition
            $numPoules = $em->getRepository('App:Equipe\RefCompetition')->findByReference($refPoule);

            foreach ($numPoules as $numPoule){
                $equipe = $em->getRepository('App:Equipe\Equipe')->find($numPoule->getEquipe()->getId());
                $match->addEquipeMatch($equipe);
            }
            $this->getDoctrine()->getManager()->flush();
            $request->getSession()->getFlashBag()->add('success', 'Modification de la Rencontre');
            return $this->redirectToRoute('admin_match_index');
        }

        return $this->render('admin/match/match/edit.html.twig', array(
            'match' => $match,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Editions des matchs
     *
     */
    public function editMatchsAction($semaine, Request $request)
    {
        // On récupère la liste des matchs
        $em = $this->getDoctrine()->getManager();

        //On recupère les matchs par rapport à la semaine.
        $matchs = $em->getRepository('App:Match\Match')->findBySemaine($semaine);

        $data = ['matchs' => $matchs];
        $form = $this->createFormBuilder($data)
            ->add('matchs', CollectionType::class, array('entry_type' => EditMatchsType::class))
            ->add('save', SubmitType::class, array('label' => 'Sauvegarder'))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            //modification des liaisons club et equipe après édition des matchs.
            $matchsAfter = $em->getRepository('App:Match\Match')->findBySemaine($semaine);
            foreach ($matchsAfter as $match){
                $date = $match->getDate();//On récupère la date renseigné via le form equipe
                $numReceveur = $match->getNumReceveur();
                $numVisiteur = $match->getNumVisiteur();
                $refPoule = $match->getPoule();

                $match->setSemaine($date->format('Y-W'));

                // Recherche et enregistrement d'une correspondance entre l'equipe local et la bibliotèque de club. Permet de récupérer logo.
                if ($searchcodefederallocal = $em->getRepository('App:Core\Club')->findOneByNumeroFederal($numReceveur)) {
                    $match->setClubReceveur($searchcodefederallocal);};
                // Recherche et enregistrement d'une correspondance entre l'equipe visiteur et la bibliotèque de club. Permet de récupérer logo.
                if ($searchcodefederalvisiteur = $em->getRepository('App:Core\Club')->findOneByNumeroFederal($numVisiteur)) {
                    $match->setClubVisiteur($searchcodefederalvisiteur);};

                // Recherche et enregistrement d'une correspondance entre une équipe et les references de competition
                $numPoules = $em->getRepository('App:Equipe\RefCompetition')->findByReference($refPoule);

                foreach ($numPoules as $numPoule){
                    $equipe = $em->getRepository('App:Equipe\Equipe')->find($numPoule->getEquipe()->getId());
                    $match->addEquipeMatch($equipe);
                }
                $this->getDoctrine()->getManager()->flush();
            }
            return $this->redirect($this->generateUrl('admin_match_bysemaine', array('semaine'=>$semaine)));
        }

        return $this->render('admin/match/match/editMatchs.html.twig', array(
            'matchs' => $matchs,
            'form' => $form->createView(),
            'semaine' => $semaine
        ));
    }

    /**
     * Deletes a match entity.
     *
     */
    public function deleteAction(Request $request, Match $match)
    {
        $form = $this->createDeleteForm($match);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($match);
            $em->flush();
        }

        return $this->redirectToRoute('admin_match_index');
    }

    /**
     * Creates a form to delete a match entity.
     *
     * @param Match $match The match entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Match $match)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_match_delete', array('id' => $match->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
