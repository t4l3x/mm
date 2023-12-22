<?php
declare(strict_types=1);

namespace App\Services;

use App\Entity\Customer;
use App\Entity\Order;
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


    /** Todo: Fix line 47 improve logic */
    public function handleCustomer(Order $order)
    {
        $customer = $order->getCustomerId();
        $moysklad = $this->moyskladConnection->getMoySkladInstance();
        $anonymId = 000;

        // Check if customer is anonymous
        if (!$customer || $customer->getId() == $anonymId) {
            $this->logger->info('Handling anonymous customer');
            $customer = $this->handleAnonymousCustomer($anonymId);

        }

        if ($customer) {

            $customerId = $customer->getId();
            $customerName = $customer->getFirstName() . ' ' . $customer->getLastName();
            $actualAddress = $customer->getId() == $anonymId ? 'Zoomagazin.az' : '$order->getShippingAddress1()';

            try {

                if (!empty($customer->getMoysklad())) {

                    $this->logger->info('Creating customer in MoySklad');
                    $response = $moysklad->query()
                        ->entity()
                        ->counterparty()
                        ->create([
                            'code' => (string)$customerId,
                            'externalCode' => (string)$customerId,
                            'name' => $customerName,
                            'email' => $customer->getEmail(),
                            'phone' => $customer->getTelephone(),
                            'actualAddress' => $actualAddress,
                            'tags' => ['онлайн_покупатели']
                        ]);



                    $customer->setMoysklad($response->id);
                } else {
                    $this->logger->info('Updating customer in MoySklad');
                    // Update logic in Moysklad if needed
                }

                $this->entityManager->flush();
                $this->logger->info('Customer processed in MoySklad: ' . $customer->getMoysklad());
            } catch (\Exception $e) {
                $this->logger->error('Failed to process customer in MoySklad: ' . $e->getMessage());
            }
        }
    }
}