<?php

namespace App\Repository\Event;

/**
 * InscritRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class InscritRepository extends \Doctrine\ORM\EntityRepository
{
    public function getNbinscrit($idEvent)
    {
        return $this->createQueryBuilder('i')
            ->leftJoin('i.reservation', 'r')
            ->addSelect('r')
            ->select('COUNT(i.id)')
            ->where('r.evenement = :id')
            ->setParameter('id', $idEvent)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getTarifByEvent($idEvent)
    {
        return $this->createQueryBuilder('i')
            ->leftJoin('i.reservation', 'r')
            ->addSelect('r')
            ->leftJoin('i.tarif', 't')
            ->addSelect('t')
            ->select('SUM(t.prix)')
            ->where('r.evenement = :id')
            ->setParameter('id', $idEvent)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
