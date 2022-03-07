<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Application;

use VendorMachine\Machine\Domain\MachineRepository;
use VendorMachine\Shared\Domain\Coins;

final class MachineCoinsInserter
{
    public function __construct(private MachineRepository $repository)
    { 
    }

    public function __invoke(Coins $coins)
    {
        $this->repository->insertCoins($coins);
    }
}