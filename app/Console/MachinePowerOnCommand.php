<?php

namespace VendorMachine\App\Console;

use DomainException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MachinePowerOnCommand extends Command
{
    protected static $defaultName = 'machine:power:on';

    private $order;

    public function __construct()
    {
        parent::__construct(MachinePowerOnCommand::$defaultName);
    }


    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $output->writeln('Machine has been powered ON');
            
            return Command::SUCCESS;
        } catch (DomainException $e) {
            $output->writeln($e->getMessage());
        }

        return Command::FAILURE;
    }
}
