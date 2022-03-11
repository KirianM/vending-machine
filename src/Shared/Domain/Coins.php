<?php

declare(strict_types=1);

namespace VendorMachine\Shared\Domain;

use VendorMachine\Shared\Domain\Collection;

final class Coins extends Collection
{
    protected function type(): string
    {
        return Coin::class;
    }

    public static function fromArray(array $coins): Coins
    {
        return new self(array_map(function ($value) {
            return new Coin(floatval($value));
        }, $coins));
    }

    public function toArray(): array
    {
        return array_map(function ($coin) {
            return $coin->value();
        }, $this->items());
    }

    public function total(): float
    {
        return array_sum(array_map(function ($coin) {
            return $coin->value();
        }, $this->items()));
    }

    public static function extractCoinsForAmount(Coins $availableCoins, float $amount): Coins
    {
        $coins = $availableCoins->toArray();
        rsort($coins);

        $neededCoins = [];

        $remainingAmount = $amount;

        foreach ($coins as $coin) {
            if (FloatUtils::isBiggerThan($remainingAmount, $coin) || FloatUtils::areEqual($remainingAmount, $coin)) {
                $neededCoins[] = $coin;

                $remainingAmount -= $coin;
            }
        }

        return self::fromArray($neededCoins);
    }

    public static function removeCoinsFromCollection(Coins $collection, Coins $coins)
    {
        $balance = $collection->toArray();
        rsort($balance);
        
        foreach ($coins->toArray() as $coin) {
            $coinIndex = array_search($coin, $balance);

            unset($balance[$coinIndex]);
        }

        return self::fromArray($balance);
    }

    public static function merge(Coins ...$coins)
    {
        $availableCoins = [];

        foreach ($coins as $collection) {
            $availableCoins = array_merge($availableCoins, $collection->toArray());
        }

        return self::fromArray($availableCoins);
    }
}