<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Balance\Domain;

use VendorMachine\Shared\Domain\Coins;
use VendorMachine\Shared\Domain\FloatUtils;

final class Balance
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
        return ( FloatUtils::isBiggerThan($this->total(), $quantity) || FloatUtils::areEqual($this->total(), $quantity));
    }
}