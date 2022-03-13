<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Change\Domain;

use VendorMachine\Machine\Change\Domain\MachineChangeRepository;

final class MachineChangeGetter
{
    public function __construct(private MachineChangeRepository $repository)
    { 
    }

    public function __invoke(): Change
    {
        return $this->repository->get();
    }
}