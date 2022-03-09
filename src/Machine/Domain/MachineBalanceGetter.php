<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Domain;

final class MachineBalanceGetter
{
    public function __construct(private MachineBalanceRepository $repository)
    { 
    }

    public function __invoke(): Balance
    {
        return $this->repository->get();
    }
}