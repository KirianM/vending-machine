<?php

namespace VendorMachine\App\Console\Change;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use VendorMachine\Machine\Change\Application\MachineChangeSetter;
use VendorMachine\Shared\Domain\Coins;

class MachineServiceSetChangeCommand extends Command
{
    protected static $defaultName = 'service:change:set';

    public function __construct(private MachineChangeSetter $change)
    {
        parent::__construct(self::$defaultName);
    }

    protected function configure(): void
    {
        $this->addArgument(
            'coins',
            InputArgument::IS_ARRAY,
            'Space separated list of coins to set as change'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->change->__invoke(Coins::fromArray($input->getArgument('coins')));
        
        return Command::SUCCESS;
    }
}
