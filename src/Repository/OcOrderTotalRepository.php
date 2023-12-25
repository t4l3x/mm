<?php

namespace App\Repository;

use App\Entity\OcOrderTotal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OcOrderTotal>
 *
 * @method OcOrderTotal|null find($id, $lockMode = null, $lockVersion = null)
 * @method OcOrderTotal|null findOneBy(array $criteria, array $orderBy = null)
 * @method OcOrderTotal[]    findAll()
 * @method OcOrderTotal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OcOrderTotalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OcOrderTotal::class);
    }

//    /**
//     * @return OcOrderTotal[] Returns an array of OcOrderTotal objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?OcOrderTotal
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
