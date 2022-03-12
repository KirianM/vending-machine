<?php

namespace VendorMachine\App\Console\Products;

use DomainException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use VendorMachine\Machine\Products\Application\MachineProductsList;

class MachineListProductCommand extends Command
{
    protected static $defaultName = 'machine:products:list';

    public function __construct(
        private MachineProductsList $list,
    ) {
        parent::__construct(self::$defaultName);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $products = $this->list->__invoke();

        $table = new Table($output);
        $table
            ->setHeaders(['Name', 'Price', 'Stock'])
            ->setRows(array_map(function ($product) {
                return [
                    $product->name()->value(),
                    $product->price()->value(),
                    $product->stock()->value()
                ];
            }, $products->getIterator()->getArrayCopy()));

        $table->render();

        return Command::SUCCESS;
    }
}
