<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Balance\Application;

use VendorMachine\Machine\Balance\Domain\MachineBalanceGetter;
use VendorMachine\Machine\Balance\Domain\MachineBalanceRepository;
use VendorMachine\Shared\Domain\Coins;

final class MachineCoinsReturn
{
    public function __construct(private MachineBalanceRepository $repository, private MachineBalanceGetter $balanceGetter)
    { 
    }

    public function __invoke(): Coins
    {
        $balance = $this->balanceGetter->__invoke();

        $coins = $balance->coins();

        $balance = $balance->empty();

        $this->repository->save($balance);

        return $coins;
    }
}