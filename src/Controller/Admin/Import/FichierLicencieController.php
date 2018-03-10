<?php

namespace App\Controller\Admin\Import;

use App\Entity\Core\Licencie;
use App\Entity\Import\FichierLicencie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Fichierlicencie controller.
 *
 */
class FichierLicencieController extends Controller
{
    /**
     * Lists all fichierLicencie entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fichierLicencies = $em->getRepository('App:Import\FichierLicencie')->findAll();

        //On boucle pour afficher le boutton de suppression
        foreach ($fichierLicencies as $fichierLicencie)
        {
            $deleteForm = $this->createDeleteForm($fichierLicencie);
        }

        return $this->render('admin/import/fichierlicencie/index.html.twig', array(
            'fichierLicencies' => $fichierLicencies,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a new fichierLicencie entity.
     *
     */
    public function newAction(Request $request)
    {
        $fichierLicencie = new Fichierlicencie();
        $form = $this->createForm('App\Form\Import\FichierLicencieType', $fichierLicencie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fichierLicencie);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Fichier bien enregistrée.');
            return $this->redirectToRoute('admin_import_fichierlicencie', array('id' => $fichierLicencie->getId()));

        }

        return $this->render('admin/import/fichierlicencie/new.html.twig', array(
            'fichierLicencie' => $fichierLicencie,
            'form' => $form->createView(),
        ));
    }

    public function importLicencieAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $fileToImport = $em->getRepository('App:Import\FichierLicencie')->find($id);
        // On définit le nom du fichier import + l'extension pour la root.
        $fileName = $fileToImport->getId().'.txt';
        //Chemin du fichier d'import
        $root = dirname(__FILE__);
        $path = 'import/fichier/licencies/'.$fileName;
        $file = fopen($path, 'r');

        // Tableau qui va contenir les éléments extraits du fichier CSV
        $infosFichier = array();
        $row ="0" ; // Représente la ligne

        // Import du fichier CSV
        if (($handle = $file) !== FALSE) { // Lecture du fichier, à adapter
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) { // Eléments séparés par un point-virgule, à modifier si necessaire
                $num = count($data); // Nombre d'éléments sur la ligne traitée
                $row++;
                if($row==1) continue;
                for ($c = 0; $c < $num; $c++) {
                    $infosFichier[$row] = array(
                        "nom" => $data[0],
                        "prenom" => $data[1],
                        "licence" => $data[2],
                        "birthday" => $data[3],
                        "mail" => $data[4],
                        "portable" => $data[5],
                        "tel" => $data[6]
                    );
                }
            }
            fclose($handle);
        }

        // Lecture du tableau contenant les infos matchs et ajout dans la base de données
        foreach ($infosFichier as $infoFichier) {

            $licencie = $em->getRepository('App:Core\Licencie')
                ->findOneByBirthday(\date_create_from_format('d/m/Y', $infoFichier["birthday"]));

            // If the user doest not exist we create one
            if(!is_object($licencie)){
                $licencie = new Licencie();
            }

            // Hydrate l'objet avec les informations provenants du fichier CSV
            $licencie->setNom($infoFichier["nom"]);
            $licencie->setPrenom($infoFichier["prenom"]);
            $licencie->setBirthday(\date_create_from_format('d/m/Y', $infoFichier["birthday"]));
            $licencie->setMail($infoFichier["mail"]);
            $licencie->setTel($infoFichier["tel"]);
            $licencie->setPortable($infoFichier["portable"]);
            $licencie->setNumeroLicence($infoFichier["licence"]);
            $licencie->setFichierLicencie($fileToImport);
            $em->persist($licencie);
        }

        //On indique que l'import à été réalisé
        $fileToImport->setImport(true);
        $em->persist($fileToImport);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Importation des licenciés effectuée');
        return $this->redirect( $this->generateUrl('admin_import_fichierlicencie') );
    }


    /**
     * Finds and displays a fichierLicencie entity.
     * Redirection pour confirmer la suppresion
     */
    public function suppressionAction(FichierLicencie $fichierLicencie)
    {
        $deleteForm = $this->createDeleteForm($fichierLicencie);

        return $this->render('admin/import/fichierlicencie/delete.html.twig', array(
            'fichierLicencie' => $fichierLicencie,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Deletes a fichierLicencie entity.
     *
     */
    public function deleteAction(Request $request, FichierLicencie $fichierLicencie)
    {
        $form = $this->createDeleteForm($fichierLicencie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fichierLicencie);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'La suppression du fichier' . $fichierLicencie->getName().'a bien été effectuée');
        }
        else{
            $this->get('session')->getFlashBag()->add('error',  'Erreur lors de la suppression du fichier' . $fichierLicencie->getName() );
        }

        return $this->redirectToRoute('admin_import_fichierlicencie');
    }

    /**
     * Creates a form to delete a fichierLicencie entity.
     *
     * @param FichierLicencie $fichierLicencie The fichierLicencie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FichierLicencie $fichierLicencie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_import_fichierlicencie_delete', array('id' => $fichierLicencie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
