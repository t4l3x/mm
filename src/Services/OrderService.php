<?php
declare(strict_types=1);

namespace App\Services;

use App\Entity\Order;
use App\Repository\OrderProductRepository;
use App\Repository\OrderTotalRepository;
use App\Repository\OrderRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Psr\Log\LoggerInterface;

class OrderService
{

    private array $shippings = [
        'flatplusfree.free' 		=> '274b7085-ca0a-11e8-9ff4-315000957bad',
        'free.free' 				=> '274b7085-ca0a-11e8-9ff4-315000957bad',
        'flatplusfree.flatplusfree' => '29055932-ca0a-11e8-9ff4-31500095815b',
        'pickup.pickup' 			=> '2f9b7a3f-ca0a-11e8-9ff4-3150009597d1',
    ];

    private array $attributes = [
        'shipping_address_1' 	=> '2cc9d4d1-57a3-11ec-0a80-0960001a4eaa',
        'shipping_method' 		=> '9b8ce62b-ca62-11e8-9107-5048002c5059',
        'payment_method' 		=> '9b8ce83b-ca62-11e8-9107-5048002c505a',
        'comment' 				=> '61a80fcc-6832-11ec-0a80-069f009978d9',
        // ... other mappings
    ];

    private int $anonymId = 2922;

    private array $orderStates = [
        '1'		=> 'dd18d3d0-c992-11e8-9109-f8fc0027f24d',
        '2'		=> 'dd18d6a0-c992-11e8-9109-f8fc0027f24e',
        '5'		=> 'dd18d9eb-c992-11e8-9109-f8fc0027f251',
        '7'		=> 'dd18dbc9-c992-11e8-9109-f8fc0027f253',
        '11'	=> 'dd18dae2-c992-11e8-9109-f8fc0027f252',
        '17'	=> 'b5f0ad57-9f54-11eb-0a80-06710014295a',
        '18'	=> 'dd18d8f6-c992-11e8-9109-f8fc0027f250',
        '19'	=> 'dd18d7e6-c992-11e8-9109-f8fc0027f24f',
        // ... other mappings
    ];

    private array $drivers = [
        '11'	=> '5f9eabd1-e215-11eb-0a80-04a4001b55a7',
        '14'	=> '5596e601-6810-11ec-0a80-0178009b53bf',
        '17'	=> 'fd0a56b0-8685-11ea-0a80-05e8000ab74e',
        '22'	=> '05f945b4-70ec-11eb-0a80-08cf00029d6f',
        '25'	=> '16c6aaf7-1e96-11ec-0a80-0dd10032626a',

    ];

    private array $operators = [
        '4'		=> '57bbde88-8686-11ea-0a80-00d5000a868f',
        '5'		=> 'd2226f47-5e70-11ec-0a80-00bc0011c221',
        '15'	=> 'e150a2f2-cdd3-11eb-0a80-0311003b6fb0',
        '24'	=> '5272db24-f399-11eb-0a80-054300343339',
        '25'	=> '16c6aaf7-1e96-11ec-0a80-0dd10032626a',
        '26'	=> '18b5036b-ff25-11eb-0a80-06f10002f6f6',
        // ... other mappings
    ];
    public function __construct(
        private OrderRepository        $orderRepository,
        private OrderTotalRepository   $orderTotalRepository,
        private OrderProductRepository $orderProductRepository,
        private CustomerService        $customerService,
        private MoySkladDataService    $moyskladService,
        private OrderProductService    $orderProductService,
        private LoggerInterface        $logger,
        private EntityManagerInterface $entityManager,

    )
    {

    }

    public
    function syncOrders(): void
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

//                $this->customerService->handleCustomer( $order);
//                $this->processOrderDiscounts($order);
//                dd($this->processProducts($order));

//                $discounts = $this->processOrderDiscounts($order);
//                $pos = $this->orderProductService->processOrderProducts($order, $discounts['discount']);
                $shipping = $this->processShippingDetails($order);
                dd($shipping);
            } catch (\Exception $e) {
                $this->logger->error('Error updating order in Moysklad: ' . $e->getMessage());

            }
            break;
        }


    }

    /**
     * @throws NonUniqueResultException
     */
    private
    function processShippingDetails(Order $order): array
    {
        $shippingDetails = $this->orderTotalRepository->findShippingDetailsByOrderId($order->getOrderId());
        $positions = [];

        if ($shippingDetails) {
            $this->logger->info("Shipping found for order {$this->shippings[$order->getShippingCode()]}.");

            $shippingPosition = [
                'quantity'    => 1,
                'price'       => floatval($shippingDetails->getValue()) * 100,
                'discount'    => 0,
                'vat'         => 0,
                'shipped'     => true,
                'assortment'  => [
                    'meta' => [
                        'href'       => 'https://online.moysklad.ru/api/remap/1.1/entity/product/' . $this->shippings[$order->getShippingCode()],
                        'type'       => 'service',
                        'mediaType'  => 'application/json',
                    ]
                ]
            ];
            $positions[] = $shippingPosition;
        } else {
            $this->logger->info("Shipping code not found for order {$order->getOrderId()}.");
        }

        return $positions;
    }

    private
    function processOrderDiscounts(Order $order): array
    {
        // Fetch all related totals in one query using a custom method in OrderTotalRepository
        $totals = $this->orderTotalRepository->findDiscountDataByOrderId($order->getOrderId());

        $discountData = ['coupon' => 0, 'reward' => 0, 'sub_total' => 0];
        foreach ($totals as $total) {
            $discountData[$total['code']] = abs((float)$total['value']);
        }

        $totalReward = $discountData['coupon'] + $discountData['reward'];
        $discount = $discountData['sub_total'] > 0
            ? ($totalReward / $discountData['sub_total']) * 100
            : 0;

        return [
            'discount' => $discount,
            'coupon' => $discountData['coupon'],
            'reward' => $discountData['reward']
        ];
    }

    /**
     * @throws \Exception
     */
//    private function syncSingleOrder(Order $order): void
//    {
//        $discounts = $this->processOrderDiscounts($order);
//        $positions = $this->orderProductService->processOrderProducts($order, $discounts['discount']);
//        $shippingDetails = $this->processShippingDetails($order);
//
//        // Update order in Moysklad or other actions here...
//
//        $this->logger->info("Order {$order->getOrderId()} synced successfully.");
//    }
// Other methods...
}