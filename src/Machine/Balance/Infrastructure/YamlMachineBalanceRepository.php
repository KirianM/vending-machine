<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Balance\Infrastructure;

use VendorMachine\Machine\Balance\Domain\Balance;
use VendorMachine\Machine\Domain\BalanceLeft;
use VendorMachine\Machine\Balance\Domain\MachineBalanceRepository;
use VendorMachine\Shared\Domain\Coins;
use VendorMachine\Shared\Infrastructure\YamlMachineRepository;

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