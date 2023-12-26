<?php
declare(strict_types=1);

namespace App\Services;


class MoySkladDataService
{
    private $moyskladConnection;

    public function __construct(MoyskladConnection $moyskladConnection)
    {
        $this->moyskladConnection = $moyskladConnection->getMoySkladInstance();
    }

    // Example method to fetch orders
    public function fetchOrders()
    {
        $moysklad = $this->moyskladConnection;
        // Logic to fetch orders using $moysklad
    }

    // Method to fetch products
    public function fetchProducts()
    {
        try {
            return $this->moyskladConnection->query()
                ->entity()
                ->product()
                ->limit(100) // Adjust limit as needed
                ->get();

        } catch (\Exception $e) {
            // Handle exception
            throw new \Exception('Failed to fetch products: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }


    public function searchProducts($sku)
    {
        dd($sku);
        try {

            return $this->moyskladConnection->query()
                ->entity()
                ->product()
                ->search($sku) // Adjust limit as needed
                ->get();
        } catch (\Exception $e) {
            //
            // Handle exception
            throw new \Exception('Failed to fetch products: ' . $e->getMessage(), $e->getCode(), $e);
        }

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
        try {
            return $this->moyskladConnection->query()
                ->entity()
                ->customerorder()
                ->byId($orderId)
                ->get();

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
        try {
            return $this->moyskladConnection->query()
                ->entity()
                ->customerorder()
                ->byId($orderId)
                ->update($updatedData);

        } catch (\Exception $e) {
            // Handle exception
            throw new \Exception('Failed to update order in Moysklad: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }
}