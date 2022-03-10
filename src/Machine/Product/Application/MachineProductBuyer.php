<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Product\Application;

use RuntimeException;
use VendorMachine\Machine\Product\Domain\ProductName;
use VendorMachine\Machine\Product\Domain\MachineProductsRepository;
use VendorMachine\Shared\Domain\Coins;

final class MachineProductBuyer
{
    public function __construct(private MachineProductsRepository $repository)
    { 
    }

    public function __invoke(ProductName $name)
    {
        $product = $this->repository->search($name);
        
        if (!$product->isInStock()) {
            throw new RuntimeException('Out of stock');
        }

        $product = $product->decreaseStock();

        $this->repository->save($product);
    }
}