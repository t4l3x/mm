<?php
declare(strict_types=1);

namespace App\Services;

use App\Entity\Customer;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class CustomerService
{
    private $entityManager;
    private $logger;
    private $moyskladConnection;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger, MoyskladConnection $moyskladConnection)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
        $this->moyskladConnection = $moyskladConnection->getMoySkladInstance();
    }


    /** Todo: Fix line 47 improve logic */
    public function handleCustomer(Order $order)
    {

        $customer = $order->getCustomerId();

        $anonymId = 2922;

        // Check if customer is anonymous
        if (!$customer || $customer->getId() == $anonymId) {
            $this->logger->info('Handling anonymous customer');
            $order->setCustomData(['anonym' => $anonymId]);
            $customer = $order->getCustomData()['anonym'];

        }

        if ($customer) {

            $customerId = $customer->getId();
            $customerName = $customer->getFirstName() . ' ' . $customer->getLastName();
            $actualAddress = $customer->getId() == $anonymId ? 'Zoomagazin.az' : $order->getShippingAddress1();

            try {

                if (empty($customer->getMoysklad())) {

                    $this->logger->info('Creating customer in MoySklad');
                    $response = $this->moyskladConnection->query()
                        ->entity()
                        ->counterparty()
                        ->create([
                            'code' => (string)$customerId,
                            'externalCode' => (string)$customerId,
                            'name' => $customerName,
                            'email' => $customer->getEmail(),
                            'phone' => $customer->getTelephone(),
                            'actualAddress' => $actualAddress,
                            'tags' => ['онлайн_покупатели']
                        ]);

                    $order->setCustomData(
                        [
                            'agent' => ['meta' => [
                                'href' => $response['meta']['href'],
                                'type' => 'counterparty',
                                "mediaType" => "application/json"
                            ]]
                        ]
                    );

                    $customer->setMoysklad($response['id']);
                } else {
                    $this->logger->info('Updating customer in MoySklad');


                    $order->setCustomData(
                        [
                            'agent' => ['meta' => [
                                'href' => "https://api.moysklad.ru/api/remap/1.2/entity/counterparty/{$customer->getMoysklad()}",
                                'type' => 'counterparty',
                                "mediaType" => "application/json"
                            ]]
                        ]
                    );

//                    if (empty($customer->tag)) {
//                        try {
//                            $response = $this->moyskladConnection->query()
//                                ->entity()
//                                ->counterparty()
//                                ->byId($customer->getMoysklad())
//                                ->update(['tags' => ['онлайн_покупатели']]);
//
//                            // Handle the response as needed
//                        } catch (\Exception $e) {
//                            // Handle exception
//                            throw new \Exception('Failed to update customer tags: ' . $e->getMessage(), $e->getCode(), $e);
//                        }
//                    }
                    $this->updateCustomerState($customer->getMoysklad());

                    // Update logic in Moysklad if needed
                }

                $this->entityManager->flush();

                $this->logger->info('Customer processed in MoySklad: ' . $customer->getMoysklad());
                return $order;
            } catch (\Exception $e) {
                $this->logger->error('Failed to process customer in MoySklad: ' . $e->getMessage());
            }
        }
    }

    /**
     * @throws \Exception
     */
    public function updateCustomerState(string $customerId, string $stateHref = "https://api.moysklad.ru/api/remap/1.2/entity/counterparty/metadata/states/dd15a400-c992-11e8-9109-f8fc0027f24a"): void
    {

        try {
            $stateData = [
                'state' => [
                    'meta' => [
                        'href' => $stateHref,
                        'type' => 'state',
                        'mediaType' => 'application/json'
                    ]
                ]
            ];

            $this->moyskladConnection->query()
                ->entity()
                ->counterparty()
                ->byId($customerId)
                ->update($stateData);

            // Handle the response as needed
        } catch (\Exception $e) {
            // Handle exception

            throw new \Exception('Failed to update customer state: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }
}