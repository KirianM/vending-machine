<?php

namespace VendorMachine\App\Console;

use DomainException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use VendorMachine\Machine\Application\MachineCoinsInserter;

class MachineInsertCoinsCommand extends Command
{
    protected static $defaultName = 'machine:coins:insert';

    public function __construct(private MachineCoinsInserter $inserter)
    {
        parent::__construct(self::$defaultName);
    }


    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return Command::SUCCESS;
    }
}
