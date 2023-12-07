<?php
declare(strict_types=1);

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class CustomerService
{
    private $entityManager;
    private $logger;
    private $moyskladConnection;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger, MoyskladConnection $moyskladConnection)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
        $this->moyskladConnection = $moyskladConnection;
    }

    public function handleCustomer($customerId, $anonymId, $orderData)
    {
        // Logic to handle customer
        // Fetch or create customer in MoySklad
        // Return the customer data or MoySklad reference
    }
}