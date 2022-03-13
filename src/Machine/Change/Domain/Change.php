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

    public function total(): float
    {
        return $this->coins()->total();
    }

    public function empty(): void
    {
        $this->coins = Coins::empty();
    }

    public function insertCoins(Coins $coins): void
    {
        $this->coins = Coins::merge($this->coins(), $coins);
    }

    public function isEnough(float $quantity): bool
    {
        return ($this->total() - $quantity > 0);
    }
}