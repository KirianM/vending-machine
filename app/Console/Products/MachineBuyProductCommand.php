<?php

namespace VendorMachine\App\Console\Products;

use DomainException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use VendorMachine\Machine\Products\Application\MachineProductBuyer;
use VendorMachine\Machine\Balance\Domain\NotEnoughMoney;
use VendorMachine\Machine\Products\Domain\OutOfStock;
use VendorMachine\Machine\Products\Domain\ProductName;

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
        try {
            $change = $this->buyer->__invoke(new ProductName($input->getArgument('name')));

            $output->writeln($input->getArgument('name') . ' ' . implode(', ', $change->toArray()));
        } catch (OutOfStock $e) {
            $output->writeln(sprintf('Product <%s> is out of stock', $input->getArgument('name')));
        } catch (NotEnoughMoney $e) {
            $output->writeln(sprintf('Current balance is not enough to buy <%s>', $input->getArgument('name')));
        }

        return Command::SUCCESS;
    }
}
