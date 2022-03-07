<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Domain;

use VendorMachine\Shared\Domain\Coins;

interface MachineRepository
{
    public function currentBalance(): float;

    public function insertCoins(Coins $coins): void;
}