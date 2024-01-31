<?php

namespace App\Command;

use App\Services\OrderService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'sync-order',
    description: 'Add a short description for your command',
)]
class SyncOrderCommand extends Command
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        parent::__construct();
        $this->orderService = $orderService;
    }

    protected function configure(): void
    {
        $this
            // You can add more arguments or options as needed
            ->setDescription('Synchronizes modified orders with Moysklad')
            ->addArgument('order_id', InputArgument::REQUIRED, 'The order id for modified orders');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $order_id = $input->getArgument('order_id');

        try {
            $this->orderService->syncOrder($order_id); // assuming syncOrders now accepts startDate
            $io->success('Modified orders have been synchronized successfully with Moysklad.');
        } catch (\Exception $e) {
            $io->error('An error occurred during synchronization: ' . $e);
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
