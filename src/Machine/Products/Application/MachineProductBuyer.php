<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Products\Application;

use VendorMachine\Machine\Balance\Domain\MachineBalanceSpend;
use VendorMachine\Machine\Products\Domain\ProductName;
use VendorMachine\Machine\Products\Domain\MachineProductsRepository;
use VendorMachine\Machine\Products\Domain\NotEnoughMoney;
use VendorMachine\Machine\Products\Domain\OutOfStock;
use VendorMachine\Shared\Domain\Coins;

final class MachineProductBuyer
{
    public function __construct(private MachineProductsRepository $repository, private MachineBalanceSpend $balanceSpend)
    { 
    }

    public function __invoke(ProductName $name): Coins
    {
        $product = $this->repository->search($name);
        
        if (!$product->isInStock()) {
            throw new OutOfStock();
        }

        $change = $this->balanceSpend->__invoke($product->price()->value());

        $product = $product->decreaseStock();

        $this->repository->save($product);

        return $change;
    }
}