<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Products\Application;

use VendorMachine\Machine\Products\Domain\MachineProductsRepository;
use VendorMachine\Machine\Products\Domain\Products;

final class MachineProductsList
{
    public function __construct(private MachineProductsRepository $repository)
    { 
    }

    public function __invoke(): Products
    {
        return $this->repository->all();
    }
}