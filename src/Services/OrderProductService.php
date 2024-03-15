<?php
/*
 * Copyright (c) 2023. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

declare(strict_types=1);

namespace App\Services;

use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\Product;
use App\Repository\OrderProductRepository;
use App\Repository\ProductRepository;
use Psr\Log\LoggerInterface;

class OrderProductService
{
    public function __construct(
        private OrderProductRepository $orderProductRepository,
        private ProductRepository      $productRepository,
        private MoySkladDataService    $moysklad,
        private LoggerInterface        $logger
    )
    {

    }

    /**
     * @throws \Exception
     */
    public function processOrderProducts(Order $order, float $discount = 0): array
    {
        $positions = [];
        $orderProducts = $this->orderProductRepository->findByOrderId($order->getOrderId());

        // Fetch all product entities in one go if possible
        $productIds = array_map(function($op) { return $op->getProduct()->getId(); }, $orderProducts);
        $products = $this->productRepository->findBy(['id' => $productIds]);

        // Index products by ID for easy lookup
        $indexedProducts = [];
        foreach ($products as $product) {
            $indexedProducts[$product->getId()] = $product;
        }

        foreach ($orderProducts as $orderProduct) {
            $productId = $orderProduct->getProduct()->getId();

            if (!empty($indexedProducts[$productId])) {
                try {
                    $this->syncProductWithMoysklad($indexedProducts[$productId]);
                    usleep(5000);
                    if($indexedProducts[$productId]->getMoysklad() !== null)
                        $positions[] = $this->buildPositionArray($indexedProducts[$productId], $orderProduct, $discount);
                } catch (\Exception $e) {
                    $this->logger->error('Error processing product: ' . $e->getMessage());
                    // Handle the exception as required
                }
            } else {
                $this->logProductNotFound($productId);
            }
        }

        return $positions;
    }

    private function logProductNotFound(Product $orderProduct): void
    {
        $productId = $orderProduct->getId();
        $this->logger->error("Product with ID $productId not found in OC!");
    }

    /**
     * @throws \Exception
     */
    private function syncProductWithMoysklad(Product $product): void
    {

        if (!empty($product->getMoysklad())) {

            $this->logger->info('Syncing product with Moysklad', ['product_id' => $product->getId()]);
            // Assuming $product->getSku() returns the SKU of the product

            $response = $this->moysklad->searchProducts($product->getSku());

            if (!empty($response->rows)) {
                foreach ($response->rows as $mp) {

                    if ($product->getSku() == $mp['code']) {
                        $product->setMoysklad($mp['id']);
                        // Save the updated product to the database

                        $this->orderProductRepository->save($product);
                        $this->logger->info('Product synced with Moysklad', ['moysklad_id' => $mp['id']]);
                        break;
                    }
                }
            }
        } else {
            $this->logger->info('Product already synced with Moysklad', ['moysklad_id' => $product->getMoysklad()]);
        }
    }

    private function buildPositionArray(Product $product, OrderProduct $orderProduct, float $discount): array
    {



        $productType = $product->getComponent() ? 'bundle' : 'product';
        $product = $product->getMoysklad();
        echo  "https://api.moysklad.ru/api/remap/1.2/entity/".$productType.'/'.$product."\n";
        return [
            'quantity' => floatval($orderProduct->getQuantity()) ?? 1,
            'reserve' => floatval($orderProduct->getQuantity()) ?? 1,
            'price' => $orderProduct->getPrice() * 100,
            'discount' => $discount,
            'vat' => 0,
            'assortment' => [
                'meta' => [
                    'href' => "https://api.moysklad.ru/api/remap/1.2/entity/".$productType.'/'.$product,
                    "metadataHref" => "https://api.moysklad.ru/api/remap/1.2/entity/product/metadata",
                    'type' => $productType,
                    'mediaType' => 'application/json',
                ]
            ]
        ];
    }
}