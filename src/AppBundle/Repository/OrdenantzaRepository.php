<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * OrdenantzaRepository
 *
 * This class was generated by the PhpStorm "Php Annotations" Plugin. Add your own custom
 * repository methods below.
 */
class OrdenantzaRepository extends EntityRepository
{
    public function getOrdenantzabat($id)
    {
        $qb = $this->createQueryBuilder('o')
            ->select('o,p')
            ->innerJoin('o.parrafoak','p')
            ->where('o =:id')->setParameter('id', $id)
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
//            ->getArrayResult();
        return $qb;
    }
}