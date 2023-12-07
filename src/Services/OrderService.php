<?php
declare(strict_types=1);

namespace App\Services;

use App\Repository\OrderRepository;
use DateTime;

class OrderService
{
    private OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function syncOrders(): void
    {
        $startDate = new DateTime('2018-10-07');
        $statusIds = [1, 2, 5, 17, 18, 19];
        $excludedCustomerId = 3137;

        $orders = $this->orderRepository->findOrdersWithFilters($startDate, $statusIds, $excludedCustomerId);

        foreach ($orders as $order) {
            // Process each order
        }
    }

    // Other methods...
}