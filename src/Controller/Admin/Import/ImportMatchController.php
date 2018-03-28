<?php

namespace App\Controller\Admin\Import;

use App\Entity\Import\ImportMatch;
use App\Entity\Match\Match;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Fichierlicencie controller.
 *
 */
class ImportMatchController extends Controller
{
    /**
     * Lists all importMatch entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fichierMatchs = $em->getRepository('App:Import\ImportMatch')->findAll();

        return $this->render('admin/import/match/index.html.twig', array(
            'fichierMatchs' => $fichierMatchs,
        ));
    }

    /**
     * Creates a new importMatch entity.
     *
     */
    public function newAction(Request $request)
    {
        $fichierMatch = new ImportMatch();
        $form = $this->createForm('App\Form\Import\ImportMatchType', $fichierMatch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fichierMatch);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Fichier bien enregistrée.');
            return $this->redirectToRoute('admin_import_match');

        }

        return $this->render('admin/import/match/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Deletes a importMatch entity.
     *
     */
    public function deleteAction(Request $request, ImportMatch $importMatch)
    {
        $form = $this->createDeleteForm($importMatch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($importMatch);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'La suppression du fichier' . $importMatch->getName().'a bien été effectuée');
        }
        else{
            $this->get('session')->getFlashBag()->add('error',  'Erreur lors de la suppression du fichier' . $importMatch->getName() );
        }

        return $this->redirectToRoute('admin_import_match');
    }

    /**
     * Creates a form to delete a importMatch entity.
     *
     * @param importMatch $importMatch The importMatch entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ImportMatch $importMatch)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_import_match_delete', array('id' => $importMatch->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    public function importMatchsAction(ImportMatch $importMatch, Request $request)
    {
        // EntityManager pour la base de données
        $em = $this->getDoctrine()->getManager();
        // On récupère le fichier import $id
        $fileToImport = $em->getRepository('App:Import\ImportMatch')->find($importMatch);
        // On définit le nom du fichier import + l'extension pour la root.
        $fileName = $fileToImport->getId() . '.txt';

        //Chemin du fichier d'import
        $root = dirname(__FILE__);
        $path = 'import/fichier/match/'.$fileName;
        $file = fopen($path, 'r');

        // Tableau qui va contenir les éléments extraits du fichier CSV
        $fichiermatchs = array();
        $row = "0"; // Représente la ligne

        // Import du fichier CSV
        if (($handle = $file) !== FALSE) { // Lecture du fichier, à adapter
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) { // Eléments séparés par un point-virgule, à modifier si necessaire
                $num = count($data); // Nombre d'éléments sur la ligne traitée
                $row++;
                if ($row == 1) continue;
                for ($c = 0; $c < $num; $c++) {
                    $fichiermatchs[$row] = array(
                        'semaine' => $data[0],
                        'numPoule' => $data[1],
                        "competition" => $data[2],
                        "poule" => $data[3],
                        "date" => $data[4],
                        "heure" => $data[5],
                        "clubRec" => $data[6],
                        "clubVis" => $data[7],
                        "nomSalle" => $data[8],
                        "adresseSalle" => $data[9],
                        "CP" => $data[10],
                        "ville" => $data[11],
                        "numRec" => $data[12],
                        "numVis" => $data[13],
                    );
                }
            }
            fclose($handle);

        }

        // Lecture du tableau contenant les infos matchs et ajout dans la base de données
        foreach ($fichiermatchs as $fichiermatch) {

            // On crée un objet CSVMatch et Equipe
            $match = new Match();

            // Hydrate l'objet avec les informations provenants du fichier CSV
            $match->setSemaine($fichiermatch["semaine"]);
            $match->setNumPoule($fichiermatch["numPoule"]);
            $match->setCompetition($fichiermatch["competition"]);
            $match->setPoule($fichiermatch["poule"]);
            $match->setDate(\date_create_from_format('d/m/Y', $fichiermatch["date"]));
            $match->setHeure(\date_create_from_format('H:i:s', $fichiermatch["heure"]));
            $match->setLocal($fichiermatch["clubRec"]);
            $match->setVisiteur($fichiermatch["clubVis"]);
            $match->setNomSalle($fichiermatch["nomSalle"]);
            $match->setAdresseSalle($fichiermatch["adresseSalle"]);
            $match->setCpSalle($fichiermatch["CP"]);
            $match->setVille($fichiermatch["ville"]);
            $match->setNumReceveur($fichiermatch["numRec"]);
            $match->setNumVisiteur($fichiermatch["numVis"]);

            // Recherche et enregistrement d'une correspondance entre l'equipe local et la bibliotèque de club. Permet de récupérer logo.
            if ($searchcodefederallocal = $em->getRepository('App:Core\Club')->findOneByNumeroFederal($fichiermatch["numRec"])) {
                $match->setClubReceveur($searchcodefederallocal);};

            // Recherche et enregistrement d'une correspondance entre l'equipe visiteur et la bibliotèque de club. Permet de récupérer logo.
            if ($searchcodefederalvisiteur = $em->getRepository('App:Core\Club')->findOneByNumeroFederal($fichiermatch["numVis"])) {
                $match->setClubVisiteur($searchcodefederalvisiteur);};

            // Recherche et enregistrement d'une correspondance entre une équipe et les references de competition
            $numPoules = $em->getRepository('App:Equipe\RefCompetition')->findByReference($fichiermatch["numPoule"]);
            foreach ($numPoules as $numPoule){
                $equipe = $em->getRepository('App:Equipe\Equipe')->find($numPoule->getEquipe()->getId());
                $match->setEquipe($equipe);
            }

            // Enregistrement de l'objet pour la liaison Many to One entre les entités CSVFichier et CSVMatch en vu de son écriture  dans la base de données
            $match->setImportMatch($fileToImport);
            $em->persist($match);
        }
        //On compte le nombre de matchs importés en BDD
        $nbmatchs = count($fichiermatchs);


        //On indique que l'import à été réalisé.S
        $fileToImport->setImport(true);

        $em->persist($fileToImport);
        $request->getSession()->getFlashBag()->add('success', "Importation de " . $nbmatchs . " rencontres en base de donnée réussite");
        // Ecriture dans la base de données
        $em->flush();

        // Renvoi la réponse (ici affiche un simple OK pour l'exemple)
        return $this->redirect($this->generateUrl('admin_import_match'));
    }

}