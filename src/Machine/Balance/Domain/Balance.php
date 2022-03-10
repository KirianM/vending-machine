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

    public function empty(): Balance
    {
        return new self(new Coins([]));
    }

    public function removeCoins(Coins $coins): Balance
    {
        return new self(Coins::removeCoinsFromCollection($this->coins(), $coins));
    }

    public function insertCoins(Coins $coins): Balance
    {
        return new self(
            Coins::fromArray(array_merge($this->coins()->toArray(), $coins->toArray()))
        );
    }

    public function coinsFor(float $amount): Coins
    {
        return Coins::extractCoinsForAmount($this->coins(), $amount);
    }

    public function isEnough(float $quantity): bool
    {
        return ( FloatUtils::isBiggerThan($this->coins()->total(), $quantity) || FloatUtils::areEqual($this->coins()->total(), $quantity));
    }
}