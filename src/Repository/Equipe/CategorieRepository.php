<?php

namespace App\Repository\Equipe;

/**
 * CategorieRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategorieRepository extends \Doctrine\ORM\EntityRepository
{
    public function byHierarchie()
    {
        $qb = $this->createQueryBuilder('c')
            ->orderBy('c.hierarchie', 'ASC');
        return $qb->getQuery()->getResult();
    }
}
