<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Application;

use VendorMachine\Machine\Domain\MachineBalanceRepository;
use VendorMachine\Shared\Domain\Coins;

final class MachineCoinsReturn
{
    public function __construct(private MachineBalanceRepository $repository)
    { 
    }

    public function __invoke(): Coins
    {
        $balance = $this->repository->get();

        $coins = $balance->coins();

        $balance = $balance->empty();

        $this->repository->save($balance);

        return $coins;
    }
}