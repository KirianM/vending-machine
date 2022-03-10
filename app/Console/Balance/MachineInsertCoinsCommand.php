<?php

namespace VendorMachine\App\Console\Balance;

use DomainException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use VendorMachine\Machine\Balance\Application\MachineCoinsInserter;
use VendorMachine\Shared\Domain\Coin;
use VendorMachine\Shared\Domain\Coins;

class MachineInsertCoinsCommand extends Command
{
    protected static $defaultName = 'machine:coins:insert';

    public function __construct(private MachineCoinsInserter $inserter)
    {
        parent::__construct(self::$defaultName);
    }

    protected function configure(): void
    {
        $this->addArgument(
            'coins',
            InputArgument::IS_ARRAY,
            'Space separated list of coins to insert'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->inserter->__invoke(Coins::fromArray($input->getArgument('coins')));
        
        return Command::SUCCESS;
    }
}
