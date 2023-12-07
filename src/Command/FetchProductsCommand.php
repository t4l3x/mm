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
    name: 'fetch-products',
    description: 'Add a short description for your command',
)]
class FetchProductsCommand extends Command
{

    public function __construct(MoySkladDataService $moySkladService)
    {
        parent::__construct();
        $this->moySkladService = $moySkladService;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }



    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);


//         Call MoySklad service to fetch orders
//         Example:
        $orders = $this->moySkladService->fetchProducts();

        dd($orders);
        // Process and display the results
        $io->success('Orders fetched successfully.');

        return Command::SUCCESS;
    }
}
