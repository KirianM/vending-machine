<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Domain;

use VendorMachine\Machine\Domain\Balance;

interface MachineBalanceRepository
{
    public function get(): Balance;

    public function save(Balance $balance): void;
}