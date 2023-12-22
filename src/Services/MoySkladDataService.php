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

    /**
     * Fetches order data from Moysklad.
     *
     * @param string $orderId
     * @return mixed
     * @throws \Exception
     */
    public function getOrderData(string $orderId): mixed
    {
        $moysklad = $this->moyskladConnection->getMoySkladInstance();

        try {
            $response = $moysklad->query()
                ->entity()
                ->customerorder()
                ->byId($orderId)
                ->get();

            return $response;

        } catch (\Exception $e) {
            // Handle exception
            throw new \Exception('Failed to fetch order data: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Updates an order in Moysklad.
     *
     * @param string $orderId
     * @param array $updatedData
     * @return mixed
     * @throws \Exception
     */
    public function updateOrderInMoysklad(string $orderId, array $updatedData)
    {
        $moysklad = $this->moyskladConnection->getMoySkladInstance();

        try {
            $response = $moysklad->query()
                ->entity()
                ->customerorder()
                ->byId($orderId)
                ->update($updatedData);

            return $response;

        } catch (\Exception $e) {
            // Handle exception
            throw new \Exception('Failed to update order in Moysklad: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }
}