<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Application;

use VendorMachine\Machine\Domain\MachineBalanceGetter;
use VendorMachine\Machine\Domain\MachineBalanceRepository;
use VendorMachine\Shared\Domain\Coins;

final class MachineCoinsInserter
{
    public function __construct(private MachineBalanceRepository $repository, private MachineBalanceGetter $balanceGetter)
    { 
    }

    public function __invoke(Coins $coins)
    {
        $balance = $this->balanceGetter->__invoke();

        $balance = $balance->insertCoins($coins);

        $this->repository->save($balance);
    }
}