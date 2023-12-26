<?php
declare(strict_types=1);

namespace App\Services;

use App\Entity\Order;
use App\Repository\OrderProductRepository;
use App\Repository\OrderTotalRepository;
use App\Repository\OrderRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class OrderService
{

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

                dd($this->orderProductService->processOrderProducts($order));
            } catch (\Exception $e) {
                $this->logger->error('Error updating order in Moysklad: ' . $e->getMessage());
            }
            break;
        }
    }


    public
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


    private
    function processProducts(Order $order)
    {
        $orderProducts = $this->orderProductRepository->findByOrderId($order->getOrderId());

        dd($orderProducts);
    }
// Other methods...
}