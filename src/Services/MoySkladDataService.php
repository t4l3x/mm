<?php
declare(strict_types=1);

namespace App\Services;

class MoySkladDataService
{
    private $moyskladConnection;

    public function __construct(MoyskladConnection $moyskladConnection)
    {
        $this->moyskladConnection = $moyskladConnection;
    }

    // Example method to fetch orders
    public function fetchOrders()
    {
        return $moysklad = $this->moyskladConnection->getMoySkladInstance();
        // Logic to fetch orders using $moysklad
    }

    // Additional methods for other operations
}