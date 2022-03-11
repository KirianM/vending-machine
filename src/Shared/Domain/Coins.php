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

    public static function empty(): Coins
    {
        return new self([]);
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

    public function getCoinsToSumAmount(float $amount): Coins
    {
        $coins = $this->toArray();
        rsort($coins);

        $neededCoinsArray = [];

        $remainingAmount = $amount;

        foreach ($coins as $coin) {
            if (FloatUtils::isBiggerThan($remainingAmount, $coin) || FloatUtils::areEqual($remainingAmount, $coin)) {
                $neededCoinsArray[] = $coin;

                $remainingAmount -= $coin;
            }
        }
        
        $neededCoins = self::fromArray($neededCoinsArray);

        if (!FloatUtils::areEqual($neededCoins->total(), $amount)) {
            throw new NotEnoughCoins();
        }

        return $neededCoins;
    }

    public static function createFromCoinsWithoutThoseCoins(Coins $collection, Coins $coins)
    {
        $balance = $collection->toArray();
        rsort($balance);
        
        foreach ($coins->toArray() as $coin) {
            $coinIndex = array_search($coin, $balance);

            unset($balance[$coinIndex]);
        }

        return self::fromArray($balance);
    }

    public static function merge(Coins ...$coins): Coins
    {
        $availableCoins = [];

        foreach ($coins as $collection) {
            $availableCoins = array_merge($availableCoins, $collection->toArray());
        }

        return self::fromArray($availableCoins);
    }
}