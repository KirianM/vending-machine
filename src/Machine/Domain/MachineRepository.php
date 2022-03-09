<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Domain;

use VendorMachine\Machine\Domain\Product;
use VendorMachine\Machine\Domain\ItemName;
use VendorMachine\Shared\Domain\Coins;

interface MachineRepository
{
    public function currentChange(): Coins;

    public function insertCoins(Coins $coins): void;

    public function currentBalance(): Balance;

    public function balanceLeft(): BalanceLeft;

    public function emptyBalance(): void;

    public function getProduct(ItemName $productName): ?Product;

    public function saveProduct(Product $product): void;
}