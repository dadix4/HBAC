<?php

namespace App\Repository\Match;

/**
 * MatchRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MatchRepository extends \Doctrine\ORM\EntityRepository
{
    public function menuMatchs()
    {
        $qb = $this->createQueryBuilder('m')
            ->addOrderBy('m.date','DESC');
        return $qb->getQuery()->getResult();
    }

    public function getMatchs()
    {
        $qb = $this->createQueryBuilder('m')
            ->leftJoin('m.clubReceveur','clubReceveur')
            ->addSelect('clubReceveur')
            ->where('m.date >= :dateNow')
            ->setParameter('dateNow', new \Datetime(" - 1 days"))  // entre aujourd'hui
            ->orderBy('m.date', 'ASC')
            ->addOrderBy('clubReceveur.monclub', 'DESC')
            ->addOrderBy('m.heure', 'ASC');
        return $qb->getQuery()->getResult();
    }

    public function getResultats($lastSemaine)
    {
        $qb = $this->createQueryBuilder('m')
            ->leftJoin('m.equipe','e')
            ->addSelect('e')
            ->leftJoin('e.categorie','c')
            ->addSelect('c')
            ->where('m.semaine = :lastSemaine')
            ->setParameter('lastSemaine', $lastSemaine)  // la semaine derniere
            ->orderBy('c.hierarchie', 'DESC');
        return $qb->getQuery()->getResult();
    }
}
