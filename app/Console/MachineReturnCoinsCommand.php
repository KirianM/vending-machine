<?php

namespace VendorMachine\App\Console;

use DomainException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use VendorMachine\Machine\Application\MachineBalanceCoinsGetter;
use VendorMachine\Machine\Application\MachineBalanceCoinsResetter;
use VendorMachine\Shared\Domain\Coin;
use VendorMachine\Shared\Domain\Coins;

class MachineReturnCoinsCommand extends Command
{
    protected static $defaultName = 'machine:coins:return';

    public function __construct(
        private MachineBalanceCoinsGetter $balanceCoins,
        private MachineBalanceCoinsResetter $balanceReset
    ) {
        parent::__construct(self::$defaultName);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $coins = $this->balanceCoins->__invoke();
        $this->balanceReset->__invoke();

        $output->writeln(implode(', ', $coins->toArray()));
        
        return Command::SUCCESS;
    }
}
