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
    name: 'sync-orders',
    description: 'Add a short description for your command',
)]
class SyncOrdersCommand extends Command
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
            ->addArgument('startDate', InputArgument::REQUIRED, 'The start date for modified orders');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $startDate = $input->getArgument('startDate');

        try {
            $this->orderService->syncOrders($startDate); // assuming syncOrders now accepts startDate
            $io->success('Modified orders have been synchronized successfully with Moysklad.');
        } catch (\Exception $e) {
            $io->error('An error occurred during synchronization: ' . $e);
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
