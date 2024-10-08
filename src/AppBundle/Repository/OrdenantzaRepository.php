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

        public function getGuztiak() {
            $em = $this->getEntityManager();
            $dql = $em->createQueryBuilder()
                ->select('o, a, az, k')
                ->from('AppBundle:Ordenantza', 'o')
                ->leftJoin('o.atalak', 'a')
                ->leftJoin('a.azpiatalak','az')
                ->leftJoin('az.kontzeptuak', 'k')
                ->orderBy('o.kodea', 'ASC')
            ;

            return $dql->getQuery()->getResult();
        }

        public function eskuratuOrdenantza( $id )
        {
            $em = $this->getEntityManager();


            $dql = "
            SELECT o,p,a,ap,az,azp,k,m,b
                FROM AppBundle:Ordenantza o
                    LEFT JOIN o.parrafoak p
                    LEFT JOIN o.atalak a
                    LEFT JOIN a.parrafoak ap
                    LEFT JOIN a.azpiatalak az
                    LEFT JOIN az.parrafoak azp
                    LEFT JOIN az.kontzeptuak k
                    LEFT JOIN k.kontzeptumota m
                    LEFT JOIN k.baldintza b
                WHERE o.id = :id
        ";


            $consulta = $em->createQuery( $dql );
            $consulta->setParameter( 'id', $id );

            return $consulta->getResult();
        }

        public function getOrdenantzabat ( $id )
        {
            $em = $this->getEntityManager();


            $dql = "
            SELECT o,p,a,ap,az,azp,k,m,b
                FROM AppBundle:Ordenantza o
                    LEFT JOIN o.parrafoak p
                    LEFT JOIN o.atalak a
                    LEFT JOIN a.parrafoak ap
                    LEFT JOIN a.azpiatalak az
                    LEFT JOIN az.parrafoak azp
                    LEFT JOIN az.kontzeptuak k
                    LEFT JOIN k.kontzeptumota m
                    LEFT JOIN k.baldintza b
                WHERE o.id = :id
        ";


            $consulta = $em->createQuery( $dql );
            $consulta->setParameter( 'id', $id );

            return $consulta->getResult( Query::HYDRATE_ARRAY );

        }

        public function findAllOrderByKodea()
        {
            $em = $this->getEntityManager();
            $dql = $em->createQueryBuilder()
                ->select('o')
                ->from('AppBundle:Ordenantza', 'o')
                ->orderBy('o.kodea', 'ASC')
//  DEBUG              ->andWhere('o.id = :id')->setParameter(':id', 42)

            ;

            return $dql->getQuery()->getResult();

        }

    }
