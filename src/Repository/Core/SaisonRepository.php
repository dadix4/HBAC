<?php

namespace App\Repository\Core;

/**
 * SaisonRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SaisonRepository extends \Doctrine\ORM\EntityRepository
{
    public function getSaisonWithEquipeCategory()
    {
        $query = $this->createQueryBuilder('s')
            ->leftJoin('s.equipes', 'e')
            ->addSelect('e')
            ->leftJoin('e.categorie', 'c')
            ->addSelect('c')
            ->orderBy('s.slug','DESC')
            ->addOrderBy('c.hierarchie', 'ASC')
            ->getQuery();

        return $query->getResult();
    }
}
