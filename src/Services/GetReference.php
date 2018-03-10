<?php

namespace App\Services;

use Symfony\Component\Security\Core\Security;

class GetReference
{
    public function __construct($securityContext, $entityManager)
    {
        $this->securityContext = $securityContext;
        $this->em = $entityManager;
    }
    public function reference()
    {
        $date = new \DateTime();
        $annee = $date->format('Y');
        $mois = $date->format('m');
        $jour = $date->format('d');
        $reference = $this->em->getRepository('App:Ecommerce\Commandes')->findOneBy(array('valider' => 1), array('id' => 'DESC'),1,1);
        if (!$reference)
        {
            return  1 ;
        } else {
            return  $reference->getReference() +1 ;
        }
    }
}
