<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Product\Domain;

use VendorMachine\Machine\Product\Domain\Product;
use VendorMachine\Machine\Product\Domain\ProductName;
use VendorMachine\Shared\Domain\Coins;

interface MachineProductsRepository
{
    public function search(ProductName $productName): ?Product;

    public function save(Product $product): void;
}