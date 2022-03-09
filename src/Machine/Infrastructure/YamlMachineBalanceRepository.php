<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Infrastructure;

use VendorMachine\Machine\Domain\Balance;
use VendorMachine\Machine\Domain\BalanceLeft;
use VendorMachine\Machine\Domain\MachineBalanceRepository;
use VendorMachine\Shared\Domain\Coins;

final class YamlMachineBalanceRepository extends YamlMachineRepository implements MachineBalanceRepository
{
    private const COINS = 'coins';

    protected function entityFilepath(): string
    {
        return 'machine/balance.yaml';
    }

    protected function dummyEntity(): mixed
    {
        return [
            self::COINS => [],
        ];
    }

    public function get(): Balance
    {
        return new Balance(
            Coins::fromArray($this->entityState[self::COINS])
        );
    }

    public function save(Balance $balance): void
    {
        $this->entityState = [
            self::COINS => $balance->coins()->toArray(),
        ];

        $this->persist();
    }
}