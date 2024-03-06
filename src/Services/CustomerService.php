<?php
declare(strict_types=1);

namespace App\Services;

use App\Entity\Customer;
use App\Entity\Order;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Psr\Log\LoggerInterface;

class CustomerService
{
    private $entityManager;
    private $special_channel;
    private $moyskladConnection;

    private $customerRepository;

    public function __construct(CustomerRepository $customerRepository, EntityManagerInterface $entityManager, LoggerInterface $logger, MoyskladConnection $moyskladConnection)
    {
        $this->entityManager = $entityManager;
        $this->special_channel = $logger;
        $this->moyskladConnection = $moyskladConnection->getMoySkladInstance();
        $this->customerRepository = $customerRepository;
    }


    /** Todo: Fix line 47 improve logic
     * @throws NonUniqueResultException
     * @throws \Exception
     */
    public function handleCustomer(Order $order)
    {

        $customer = $order->getCustomerId();

        $anonymId = 2922;

        if (!$customer || $customer->getId() == null) {
            $customer = $this->customerRepository->getCustomerById(2922);
            $order->setCustomData(['anonym' => $anonymId]);

            $order->setCustomerId($customer);


        }
        // Check if customer is anonymous


        if ($customer) {

            $customerId = $customer->getId();
            $customerName = $customer->getFirstName() . ' ' . $customer->getLastName();
            $actualAddress = $customer->getId() == $anonymId ? 'Zoomagazin.az' : $order->getShippingAddress1();


            if (empty($customer->getMoysklad())) {

                $this->extracted($customerId, $customerName, $customer, $actualAddress, $order);
            } else {
                $this->special_channel->info('Updating customer in MoySklad');


                $order->setCustomData(
                    [
                        'agent' => ['meta' => [
                            'href' => "https://api.moysklad.ru/api/remap/1.2/entity/counterparty/{$customer->getMoysklad()}",
                            'type' => 'counterparty',
                            "mediaType" => "application/json"
                        ]]
                    ]
                );

                if (empty($customer->tag)) {
                    try {
                        $response = $this->moyskladConnection->query()
                            ->entity()
                            ->counterparty()
                            ->byId($customer->getMoysklad())
                            ->update(['tags' => ['онлайн_покупатели']]);

                        // Handle the response as needed

                    } catch (\Exception $e) {
                        // Handle exception
                        $this->special_channel->error('Failed to update customer tags: ' . $e->getCode() . ' ', ['channel' => 'special_channel']);
                        if ($e->getCode() == 404) {
                            $this->extracted($customerId, $customerName, $customer, $actualAddress, $order);

                        }
                    }
                }

                $this->updateCustomerState($customer->getMoysklad());

                // Update logic in Moysklad if needed
            }

            $this->entityManager->flush();

            $this->special_channel->info('Customer processed in MoySklad: ' . $customer->getMoysklad());

            return $order;

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

    /**
     * @param int|null $customerId
     * @param string $customerName
     * @param mixed $customer
     * @param mixed $actualAddress
     * @param Order $order
     * @return void
     * @throws \Evgeek\Moysklad\Exceptions\RequestException
     */
    protected function extracted(?int $customerId, string $customerName, mixed $customer, mixed $actualAddress, Order $order): void
    {

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
    }
}