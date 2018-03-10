<?php

namespace App\Command\Facturation;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;


class FacturesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:export-facture')
            // the short description shown while running "php bin/console list"
            ->setDescription('Export factures')
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('Pour importer les factures merci de renseigner la date sous la forme 0000-00-00')
            ->addArgument('date', InputArgument::REQUIRED, 'Date pour laquel vous souhaitez exporter les factures')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
            $date = new \datetime();
            $em = $this->getContainer()->get('doctrine')->getManager();
            $factures = $em->getRepository('App:Ecommerce\Commandes')->byDateFacture($input->getArgument('date'));

            $nbfacture = count($factures);//On compte le nombre de facture

            $output->writeln($nbfacture. 'facture(s) trouvees.');//on affiche dans la console le nombre de facture trouvée.

            //on exporte les factures si sup à 0 de comptée
            if (count($factures) > 0){
                $dir = $date->format('d-m-Y h-i-s');//creation du nom de dossier
                mkdir( __DIR__ .'/Factures/'.$dir);//creation du dossier

                //export facture par facture dans le dossier créé précédemment.
                foreach ($factures as $facture){
                $this->getContainer()->get('setNewFacture')->facture($facture)->Output(__DIR__ . '/Factures/'.$dir.'/facture'.$facture->getReference().'.pdf','F');
                }

                $output->write( 'Succes' .$nbfacture.  'Facture(s) exportee(s) ');//message de validation
            }
            else {
                $output->write( 'Pas de facture a exporter');//message dans la console si pas de facture
            }

    }
}