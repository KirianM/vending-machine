<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Application;

use VendorMachine\Machine\Domain\MachineBalanceGetter as DomainMachineBalanceGetter;
use VendorMachine\Machine\Domain\MachineRepository;
use VendorMachine\Shared\Domain\Coins;

final class MachineBalanceGetter
{
    public function __construct(private DomainMachineBalanceGetter $balanceGetter)
    { 
    }

    public function __invoke(): Coins
    {
        $balance = $this->balanceGetter->__invoke();

        return $balance->coins();
    }
}