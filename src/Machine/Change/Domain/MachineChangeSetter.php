<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Change\Domain;

use VendorMachine\Shared\Domain\Coins;

final class MachineChangeSetter
{
    public function __construct(private MachineChangeRepository $repository)
    { 
    }

    public function __invoke(Coins $coins): void
    {
        $change = $this->repository->get();

        $change->empty();
        $change->insertCoins($coins);

        $this->repository->save($change);
    }
}