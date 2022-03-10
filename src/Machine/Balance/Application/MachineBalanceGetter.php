<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Balance\Application;

use VendorMachine\Machine\Balance\Domain\MachineBalanceGetter as DomainMachineBalanceGetter;
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