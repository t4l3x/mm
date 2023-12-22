<?php
declare(strict_types=1);

namespace App\Services;

use App\Entity\Order;
use App\Repository\OrderRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class OrderService
{
    private OrderRepository $orderRepository;
    private MoySkladDataService $moyskladService;
    private LoggerInterface $logger;
    private EntityManagerInterface $entityManager;

    private CustomerService $customerService;
    public function __construct(
        OrderRepository $orderRepository,
        MoySkladDataService $moyskladService,
        LoggerInterface $logger,
        EntityManagerInterface $entityManager,
        CustomerService $customerService
    ) {
        $this->orderRepository = $orderRepository;
        $this->moyskladService = $moyskladService;
        $this->logger = $logger;
        $this->entityManager = $entityManager;
        $this->customerService = $customerService;
    }

    public function syncOrders(): void
    {
        /** @var Order[] $modifiedOrders */
        $modifiedOrders = $this->orderRepository->findModifiedOrders();

        foreach ($modifiedOrders as $order) {
            try {
//                $this->logger->info("*** UPDATE MODIFIED ORDER {$order->getOrderId()} *** " . date('Y-m-d H:i') . " ****");
//
//                $apiOrder = $this->moyskladService->getOrderData('074bd85c-992a-11ee-0a80-0cd30001c20c');
//
//                if ($apiOrder) {
//                    // Define the updated data for the order
//                    $updatedData = []; // Populate this array with the data that needs to be updated
//
//                    // Update logic for the order in Moysklad
//                    $this->moyskladService->updateOrderInMoysklad('074bd85c-992a-11ee-0a80-0cd30001c20c', $updatedData);
//
//
//                    $this->entityManager->flush();
//
//                    $this->logger->info('Order updated in Moysklad');
//                }

                $this->customerService->handleCustomer( $order);
            } catch (\Exception $e) {
                $this->logger->error('Error updating order in Moysklad: ' . $e->getMessage());
            }
            break;
        }
    }

    // Other methods...
}