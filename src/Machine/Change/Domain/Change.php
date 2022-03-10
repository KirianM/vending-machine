<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Change\Domain;

use VendorMachine\Shared\Domain\Coins;

final class Change
{
    public function __construct(private Coins $coins)
    {
    }

    public function coins(): Coins
    {
        return $this->coins;
    }

    public function empty(): Change
    {
        return new self(new Coins([]));
    }

    public function insertCoins(Coins $coins): Change
    {
        return new self(
            Coins::fromArray(array_merge($this->coins()->toArray(), $coins->toArray()))
        );
    }

    public function isEnough(float $quantity): bool
    {
        return ($this->coins()->total() - $quantity > 0);
    }
}