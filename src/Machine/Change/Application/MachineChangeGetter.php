<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Change\Application;

use VendorMachine\Machine\Change\Domain\Change;
use VendorMachine\Machine\Change\Domain\MachineChangeGetter as DomainMachineChangeGetter;

final class MachineChangeGetter
{
    public function __construct(private DomainMachineChangeGetter $getter)
    { 
    }

    public function __invoke(): Change
    {
        return $this->getter->__invoke();
    }
}