<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Balance\Domain;

use VendorMachine\Machine\Balance\Domain\Balance;

interface MachineBalanceRepository
{
    public function get(): Balance;

    public function save(Balance $balance): void;
}