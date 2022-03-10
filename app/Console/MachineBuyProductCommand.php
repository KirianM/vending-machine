<?php

namespace VendorMachine\App\Console;

use DomainException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use VendorMachine\Machine\Application\MachineProductBuyer;
use VendorMachine\Machine\Domain\ItemName;

class MachineBuyProductCommand extends Command
{
    protected static $defaultName = 'machine:products:buy';

    public function __construct(
        private MachineProductBuyer $buyer,
    ) {
        parent::__construct(self::$defaultName);
    }

    protected function configure(): void
    {
        $this->addArgument(
            'name',
            InputArgument::REQUIRED,
            'Product name you want to buy'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->buyer->__invoke(new ItemName($input->getArgument('name')));

        return Command::SUCCESS;
    }
}