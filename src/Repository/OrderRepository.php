<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Order;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    /**
     * Find orders with optional filters.
     *
     * @param DateTime|null $startDate
     * @param array|null $statusIds
     * @param int|null $excludedCustomerId
     * @return Order[]
     */
    public function findOrdersWithFilters(?DateTime $startDate, ?array $statusIds, ?int $excludedCustomerId): array
    {
        $qb = $this->createQueryBuilder('o');

        if ($startDate) {
            $qb->andWhere('o.dateAdded >= :startDate')
                ->setParameter('startDate', $startDate);
        }

        if ($statusIds) {
            $qb->andWhere('o.orderStatusId IN (:statusIds)')
                ->setParameter('statusIds', $statusIds);
        }

        if ($excludedCustomerId !== null) {
            $qb->andWhere('o.customerId != :excludedCustomerId')
                ->setParameter('excludedCustomerId', $excludedCustomerId);
        }

        $qb->orderBy('o.orderId', 'ASC');

        return $qb->getQuery()->getResult();
    }

    // OrderRepository.php

// ...

    public function findModifiedOrders(): array
    {
        $qb = $this->createQueryBuilder('o')
            ->where('o.moyskladTime IS NOT NULL')
            ->andWhere('o.dateModified != o.moyskladTime')
            ->andWhere('o.dateAdded >= :startDate')
            ->andWhere('o.moysklad  IS NOT NULL')
            ->setParameter('startDate', new DateTime('2018-10-07'))
            ->orderBy('o.orderId', 'ASC');

        return $qb->getQuery()->getResult();
    }

}