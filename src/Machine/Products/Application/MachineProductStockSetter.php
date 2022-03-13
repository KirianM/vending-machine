<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Products\Application;

use VendorMachine\Machine\Products\Domain\MachineProductsRepository;
use VendorMachine\Machine\Products\Domain\ProductName;
use VendorMachine\Machine\Products\Domain\ProductStock;

final class MachineProductStockSetter
{
    public function __construct(private MachineProductsRepository $repository)
    { 
    }

    public function __invoke(ProductName $name, ProductStock $stock): void
    {
        $product = $this->repository->search($name);

        $product->changeStock($stock);

        $this->repository->save($product);
    }
}