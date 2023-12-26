<?php

namespace App\Repository;


use App\Entity\OrderTotal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OcOrderTotal>
 *
 * @method OrderTotal|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderTotal|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderTotal[]    findAll()
 * @method OrderTotal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderTotalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderTotal::class);
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

    /**
     * Find totals by order ID
     *
     * @param int $orderId
     * @return OrderTotal[]
     */
    public function findDiscountDataByOrderId(int $orderId): array
    {
        return $this->createQueryBuilder('ot')
            ->select('ot.code, ot.value')
            ->where('ot.orderId = :orderId')
            ->setParameter('orderId', $orderId)
            ->andWhere('ot.code IN (:codes)')
            ->setParameter('codes', ['coupon', 'reward', 'sub_total'])
            ->getQuery()
            ->getArrayResult();
    }


}
