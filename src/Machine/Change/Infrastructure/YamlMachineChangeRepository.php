<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Change\Infrastructure;

use VendorMachine\Machine\Change\Domain\Change;
use VendorMachine\Machine\Change\Domain\MachineChangeRepository;
use VendorMachine\Shared\Domain\Coins;
use VendorMachine\Shared\Infrastructure\YamlMachineRepository;

final class YamlMachineChangeRepository extends YamlMachineRepository implements MachineChangeRepository
{
    private const COINS = 'coins';

    protected function entityFilepath(): string
    {
        return 'machine/change.yaml';
    }

    protected function dummyEntity(): mixed
    {
        return [
            self::COINS => [],
        ];
    }

    public function get(): Change
    {
        return new Change(
            Coins::fromArray($this->entityState[self::COINS])
        );
    }

    public function save(Change $change): void
    {
        $this->entityState = [
            self::COINS => $change->coins()->toArray(),
        ];

        $this->persist();
    }
}