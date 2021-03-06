<?php

namespace App\Repository\Event;

/**
 * TarifRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TarifRepository extends \Doctrine\ORM\EntityRepository
{
    public function getNbtarif($evenement)
    {
        $evenement->getId();

        return $this->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->where('t.evenement = :id')
            ->setParameter('id', $evenement)
            ->getQuery()
            ->getResult();
    }
}
