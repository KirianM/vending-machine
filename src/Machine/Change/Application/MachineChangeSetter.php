<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Change\Application;

use VendorMachine\Machine\Change\Domain\MachineChangeSetter as DomainMachineChangeSetter;
use VendorMachine\Shared\Domain\Coins;

final class MachineChangeSetter
{
    public function __construct(private DomainMachineChangeSetter $setter)
    { 
    }

    public function __invoke(Coins $coins): void
    {
        $this->setter->__invoke($coins);
    }
}