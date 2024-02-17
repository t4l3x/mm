<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $manager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Customer::class);
        $this->manager = $manager;
    }

    // Example custom method to find a customer by their ID

    /**
     * @throws NonUniqueResultException
     */
    public function getCustomerById(int $customerId): ?Customer
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.id = :id')
            ->setParameter('id', $customerId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    // Example custom method to update customer details
    public function updateCustomer(Customer $customer): void
    {
        $this->manager->persist($customer);
        $this->manager->flush();
    }

}