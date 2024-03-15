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

    /**
     * Create a new customer order in Moysklad.
     *
     * @param array $orderData
     * @return mixed
     * @throws \Exception
     */
    public function createCustomerOrder(array $orderData): mixed
    {

        dd($orderData);
        try {
            return $this->moyskladConnection->query()
                ->entity()
                ->customerorder()
                ->create($orderData);
        } catch (\Exception $e) {
            throw new \Exception('Failed to create customer order: ' . $e->getMessage() . ' order id ' .$orderData['name'] ?? '@', $e->getCode(), $e);
        }
    }

    /**
     * Create a demand (shipment) document in Moysklad.
     *
     * @param array $shipmentData
     * @return mixed
     * @throws \Exception
     */
    public function createDemandDocument(array $shipmentData)
    {
        try {
            return $this->moyskladConnection->query()
                ->entity()
                ->demand()
                ->create($shipmentData);
        } catch (\Exception $e) {
            throw new \Exception('Failed to create demand document: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Gets a shipment template for a specific order from Moysklad.
     *
     * @param string $orderHref The href of the customer order.
     * @return mixed
     * @throws \Exception
     */
    public function getShipmentTemplate(string $orderHref): mixed
    {
        try {
            return $this->moyskladConnection->query()
                ->endpoint('entity')
                ->method('demand')
                ->method('new')
                ->update([
                    'customerOrder' => [
                        'meta' => [
                            "href" => $orderHref,
                            "metadataHref" => "https://api.moysklad.ru/api/remap/1.2/entity/customerorder/metadata",
                            "type" => "customerorder",
                            "mediaType" => "application/json"
                        ]
                    ]
                ]);
        } catch (\Exception $e) {
            throw new \Exception('Failed to get shipment template: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Create a payment document in Moysklad.
     *
     * @param array $paymentData
     * @return mixed
     * @throws \Exception
     */
    public function createPaymentDocument(array $paymentData): mixed
    {
        try {
            return $this->moyskladConnection->query()
                ->entity()
                ->paymentin()
                ->create($paymentData);
        } catch (\Exception $e) {
            throw new \Exception('Failed to create payment document: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }


    /**
     * Creates a payment document template and returns its details.
     *
     * @param string $orderHref The href of the customer order.
     * @return mixed
     * @throws \Exception
     */
    public function createPaymentDocumentTemplate(string $orderHref)
    {
        try {
            return $this->moyskladConnection->query()
                ->endpoint('entity')
                ->method('paymentin')
                ->method('new')
                ->update([
                    'operations' => [[
                        'meta' => [
                            "href" => $orderHref,
                            "metadataHref" => "https://api.moysklad.ru/api/remap/1.2/entity/customerorder/metadata",
                            "type" => "customerorder",
                            "mediaType" => "application/json"
                        ]
                    ]]
                ]);
        } catch (\Exception $e) {
            throw new \Exception('Failed to create payment document template: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }
}