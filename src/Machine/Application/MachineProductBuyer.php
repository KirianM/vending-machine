<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Application;

use RuntimeException;
use VendorMachine\Machine\Domain\ItemName;
use VendorMachine\Machine\Domain\MachineRepository;
use VendorMachine\Shared\Domain\Coins;

final class MachineProductBuyer
{
    public function __construct(private MachineRepository $repository)
    { 
    }

    public function __invoke(ItemName $name)
    {
        $product = $this->repository->getProduct($name);
        
        if (!$product->isInStock()) {
            throw new RuntimeException('Out of stock');
        }

        $product = $product->decreaseStock();

        $this->repository->saveProduct($product);
    }
}