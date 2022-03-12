<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Products\Domain;

use VendorMachine\Machine\Products\Domain\Product;
use VendorMachine\Machine\Products\Domain\ProductName;

interface MachineProductsRepository
{
    public function search(ProductName $productName): ?Product;

    public function all(): Products;

    public function save(Product $product): void;
}