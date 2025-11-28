<?php

namespace App\Repository;

use App\Entity\Azpiatala;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Azpiatala>
 *
 * @method Azpiatala|null find($id, $lockMode = null, $lockVersion = null)
 * @method Azpiatala|null findOneBy(array $criteria, array $orderBy = null)
 * @method Azpiatala[]    findAll()
 * @method Azpiatala[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AzpiatalaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Azpiatala::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Azpiatala $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Azpiatala $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findAzpiatalakByUdala($udala) {
        return $this->createQueryBuilder('a')
            ->select('a.id, a.kodea, a.izenburuaeu')
            ->andWhere('a.udala = :udala')
            ->setParameter('udala', $udala)
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getAzpiatalakByUdala($udalaId) {
        $qb = $this->createQueryBuilder('aa')
            ->select('aa.id,aa.kodea_prod,aa.izenburuaeu_prod,aa.izenburuaes_prod,at.izenburuaeu_prod as atalaeu_prod, at.izenburuaes as atalaes_prod')
            ->innerJoin('aa.udala', 'u', 'WITH', 'u.id = :udalaId')
            ->innerJoin('aa.atala', 'at', 'WITH', 'aa.atala = at.id')
            ->setParameter('udalaId', $udalaId)
            ->andWhere('((aa.ezabatu IS NULL) or (aa.ezabatu <> 1))');
        $azpiAtalak = $qb->getQuery()->getResult();
        return $azpiAtalak;
    }
     
    public function getAzpiatalaByAtala($atalaId){
        $qb = $this->createQueryBuilder('a')
        ->select('a.id,a.kodea_prod,a.izenburuaeu_prod,a.izenburuaes_prod')
        ->innerJoin('a.atala', 'at', 'WITH', 'at.id = :atalaId')
        ->setParameter('atalaId', $atalaId)
        ->andWhere('((a.ezabatu IS NULL) or (a.ezabatu <> 1))');
        $azpiAtalak = $qb->getQuery()->getResult();
        return $azpiAtalak;
    }    
}
