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

//    public function handleCustomer(Order $order)
//    {
//        // Fetching the Moysklad instance
//        $customer = $order->getCustomer();
//        $moysklad = $this->moyskladConnection->getMoySkladInstance();
//        $customerId = $order->getCustomer()->getId();
//
//        // Assuming you have a Customer entity and repository
//
//        if (empty($order->getMoysklad())) {
//            $this->logger->info('Creating customer in MoySklad');
//
//            $customerName = $order->getFirstName() . ' ' . $order->getLastName();
//
//
//            try {
//                $response = $moysklad->query()
//                    ->entity()
//                    ->counterparty()
//                    ->create([
//                        'code' => (string)$customerId,
//                        'externalCode' => (string)$customerId,
//                        'name' => $customerName,
//                        'email' => $customer->getEmail(),
//                        'phone' => $customer->getTelephone(),
//                        'actualAddress' => $customerId == '' ? 'Zoomagazin.az' : $order->getShippingAddress1(),
//                        'tags' => ['онлайн_покупатели']
//                    ]);
//
//                $this->logger->info('Customer created in MoySklad: ' . $response->id);
//                dd($response);
//                $customer->setMoysklad($response->id);
//                $this->entityManager->flush();
//            } catch (\Exception $e) {
//                $this->logger->error('Failed to create customer in MoySklad: ' . $e->getMessage());
//                // Handle the exception appropriately
//            }
//        } else {
//            $this->logger->info('Customer found in MoySklad: ' . $customer->getMoysklad());
//
//            // Update logic here if needed
//        }
//
//    }

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

                    dd($response);

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