<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Products\Application;

use VendorMachine\Machine\Balance\Domain\MachineBalanceGetter;
use VendorMachine\Machine\Products\Domain\ProductName;
use VendorMachine\Machine\Products\Domain\MachineProductsRepository;
use VendorMachine\Machine\Products\Domain\NotEnoughMoney;
use VendorMachine\Machine\Products\Domain\OutOfStock;
use VendorMachine\Shared\Domain\Coins;

final class MachineProductBuyer
{
    public function __construct(private MachineProductsRepository $repository, private MachineBalanceGetter $balanceGetter)
    { 
    }

    public function __invoke(ProductName $name)
    {
        $product = $this->repository->search($name);
        
        if (!$product->isInStock()) {
            throw new OutOfStock();
        }

        $balance = $this->balanceGetter->__invoke();

        if (!$balance->isEnough($product->price()->value())) {
            throw new NotEnoughMoney();
        }

        $product = $product->decreaseStock();

        $this->repository->save($product);
    }
}