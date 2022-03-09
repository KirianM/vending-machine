<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Domain;

use VendorMachine\Shared\Domain\Coins;

final class Balance
{
    public function __construct(private Coins $coins)
    {
    }

    public function coins(): Coins
    {
        return $this->coins;
    }

    public function empty(): Balance
    {
        return new self(new Coins([]));
    }

    public function insertCoins(Coins $coins): Balance
    {
        return new self(
            Coins::fromArray(array_merge($this->coins()->toArray(), $coins->toArray()))
        );
    }
}