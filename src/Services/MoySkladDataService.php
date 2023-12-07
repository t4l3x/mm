<?php
declare(strict_types=1);

namespace App\Services;

use MoySklad\Entities\Products\Product;
use MoySklad\Exceptions\ApiResponseException;
use MoySklad\Lists\EntityList;

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
        $moysklad = $this->moyskladConnection->getMoySkladInstance();
        // Logic to fetch orders using $moysklad
    }

    // Method to fetch products
    public function fetchProducts()
    {
        $moysklad = $this->moyskladConnection->getMoySkladInstance();

        try {
            $response = $moysklad->query()
                ->entity()
                ->product()
                ->limit(100) // Adjust limit as needed
                ->get();

            // Assuming the products are in $response->rows based on the docs
            $products = $response;

        } catch (\Exception $e) {
            // Handle exception
            throw new \Exception('Failed to fetch products: ' . $e->getMessage(), $e->getCode(), $e);
        }

        dd( $products);
    }
}