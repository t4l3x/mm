<?php

namespace App\Repository;

use App\Entity\OrderProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderProduct>
 *
 * @method OrderProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderProduct[]    findAll()
 * @method OrderProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderProduct::class);
    }


    /**
     * Fetch products related to a specific order.
     *
     * @param int $orderId The ID of the order.
     * @return OrderProduct[] Returns an array of OrderProduct objects
     */

    public function findByOrderId(int $orderId): array
    {
        return $this->createQueryBuilder('op')
            ->select('partial op.{id, name, price, total,quantity}', 'partial order.{orderId, total}')
            ->leftJoin('op.order', 'order')
            ->where('op.order = :orderId')
            ->setParameter('orderId', $orderId)
            ->getQuery()
            ->getResult();
    }
}
