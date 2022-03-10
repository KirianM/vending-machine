<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Change\Domain;

use VendorMachine\Machine\Change\Domain\Change;

interface MachineChangeRepository
{
    public function get(): Change;

    public function save(Change $change): void;
}