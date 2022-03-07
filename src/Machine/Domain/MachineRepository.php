<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Domain;

use VendorMachine\Shared\Domain\Coins;

interface MachineRepository
{
    public function getBalance(): float;

    public function updateBalance(Coins $coins): void;
}