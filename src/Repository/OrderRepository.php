<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Order;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class OrderRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)

    {
        parent::__construct($registry, Order::class);
        $this->entityManager = $entityManager;

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

    /**
     * @throws \Exception
     */
    public function findModifiedOrders(string $startDate): array
    {
        $startDateDateTime = new DateTime($startDate);

        $qb = $this->createQueryBuilder('o')
            ->where('o.dateAdded >= :startDate')
            ->andWhere('o.orderStatusId IN (:statusIds)')
            ->andWhere('o.moysklad = :emptyString')
            ->andWhere('o.customerId != :customerId')
            ->setParameter('startDate', $startDateDateTime)
            ->setParameter('statusIds', [1, 2, 5, 17, 18, 19])
            ->setParameter('emptyString', '') // Ensure this is an empty string
            ->setParameter('customerId', 3137)
            ->orderBy('o.orderId', 'DESC');

        return $qb->getQuery()->getResult();
    }

//    public function findModifiedOrders(string $startDate): array
//    {
//        $startDateDateTime = new DateTime($startDate);
//
//        $qb = $this->createQueryBuilder('o')
//            ->where('o.moyskladTime IS NOT NULL')
//            ->andWhere('o.dateModified != o.moyskladTime')
//            ->andWhere('o.dateAdded >= :startDate')
//            ->andWhere('o.moysklad  IS NOT NULL')
//            ->setParameter('startDate', $startDateDateTime)
//            ->orderBy('o.orderId', 'DESC');
//
//        return $qb->getQuery()->getResult();
//    }

    public function findOrdersByOrderId($orderId): array
    {
        $qb = $this->createQueryBuilder('o')
            ->where('o.orderId = :orderId')
            ->andWhere('o.orderStatusId IN (:statusIds)')
            ->andWhere('o.moysklad = :emptyString')
            ->andWhere('o.customerId != :customerId')
            ->setParameter('orderId', $orderId)
            ->setParameter('statusIds', [1, 2, 5, 17, 18, 19])
            ->setParameter('emptyString', '') // Ensure this is an empty string
            ->setParameter('customerId', 3137)
            ->orderBy('o.orderId', 'DESC');

        return $qb->getQuery()->getResult();
    }




    public function updateLocalDatabase(Order $order, string $moyskladId): void
    {
        try {
            $order->setMoysklad($moyskladId);
            $order->setMoyskladTime(new \DateTime());

            $this->entityManager->persist($order);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            // Handle the exception as per your requirement
        }
    }

}