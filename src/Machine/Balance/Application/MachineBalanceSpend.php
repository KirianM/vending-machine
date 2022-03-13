<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Balance\Application;

use VendorMachine\Machine\Balance\Domain\MachineBalanceRepository;
use VendorMachine\Machine\Balance\Domain\MachineBalanceSpend as DomainMachineBalanceSpend;

final class MachineBalanceSpend
{
    public function __construct(private DomainMachineBalanceSpend $spend)
    { 
    }

    public function __invoke(float $amount): void
    {
        $this->spend->__invoke($amount);
    }
}