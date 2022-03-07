<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Application;

use InvalidArgumentException;

final class MachineCoinsInserter
{
    public function __invoke()
    {
        throw new \Exception('test');
    }
}