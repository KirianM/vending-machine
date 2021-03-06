<?php

namespace VendorMachine\App\Console\Balance;

use DomainException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use VendorMachine\Machine\Balance\Application\MachineCoinsReturn;
use VendorMachine\Shared\Domain\Coin;
use VendorMachine\Shared\Domain\Coins;

class MachineReturnCoinsCommand extends Command
{
    protected static $defaultName = 'machine:coins:return';

    public function __construct(private MachineCoinsReturn $returnCoins,) {
        parent::__construct(self::$defaultName);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $coins = $this->returnCoins->__invoke();

        $output->writeln(implode(', ', $coins->toArray()));
        
        return Command::SUCCESS;
    }
}
