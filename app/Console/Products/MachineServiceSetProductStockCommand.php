<?php

namespace VendorMachine\App\Console\Products;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use VendorMachine\Machine\Products\Application\MachineProductStockSetter;
use VendorMachine\Machine\Products\Domain\ProductName;
use VendorMachine\Machine\Products\Domain\ProductStock;

class MachineServiceSetProductStockCommand extends Command
{
    protected static $defaultName = 'machine:service:set-product-stock';

    public function __construct(private MachineProductStockSetter $stock)
    {
        parent::__construct(self::$defaultName);
    }

    protected function configure(): void
    {
        $this->addArgument(
            'product',
            InputArgument::REQUIRED,
            'Product name you want to manage'
        );

        $this->addArgument(
            'stock',
            InputArgument::REQUIRED,
            'Product stock you want to set'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->stock->__invoke(new ProductName($input->getArgument('product')), new ProductStock($input->getArgument('stock')));
        
        return Command::SUCCESS;
    }
}
