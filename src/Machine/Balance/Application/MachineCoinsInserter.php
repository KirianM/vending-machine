<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Balance\Application;

use VendorMachine\Machine\Balance\Domain\MachineBalanceGetter;
use VendorMachine\Machine\Balance\Domain\MachineBalanceRepository;
use VendorMachine\Shared\Domain\Coins;

final class MachineCoinsInserter
{
    public function __construct(private MachineBalanceRepository $repository, private MachineBalanceGetter $balanceGetter)
    { 
    }

    public function __invoke(Coins $coins)
    {
        $balance = $this->balanceGetter->__invoke();

        $balance->insertCoins($coins);

        $this->repository->save($balance);
    }
}