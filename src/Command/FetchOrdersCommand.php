<?php

namespace App\Command;

use App\Services\MoySkladDataService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'fetch-orders',
    description: 'Add a short description for your command',
)]
class FetchOrdersCommand extends Command
{

    private $moySkladService;

    public function __construct(MoySkladDataService $moySkladService)
    {
        parent::__construct();
        $this->moySkladService = $moySkladService;
    }

    protected function configure(): void
    {
        $this
            // Example: Add an argument for date range
            ->addArgument('date', InputArgument::OPTIONAL, 'Date range for fetching orders')// You can add more arguments or options as needed
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $date = $input->getArgument('date');

//         Call MoySklad service to fetch orders
//         Example:
        $orders = $this->moySkladService->fetchOrders($date);

        dd($orders);
        // Process and display the results
        $io->success('Orders fetched successfully.');

        return Command::SUCCESS;
    }
}
