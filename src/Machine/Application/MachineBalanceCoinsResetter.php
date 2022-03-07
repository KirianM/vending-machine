<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Application;

use VendorMachine\Machine\Domain\MachineRepository;

final class MachineBalanceCoinsResetter
{
    public function __construct(private MachineRepository $repository)
    { 
    }

    public function __invoke(): void
    {
        $this->repository->emptyBalance();
    }
}