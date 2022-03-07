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

    public static function fromTotal(float $total): Coins
    {
        $allowedAmounts = Coin::allowedAmounts();
        arsort($allowedAmounts, SORT_NUMERIC);

        $remainingAmount = $total;

        $coins = [];

        foreach ($allowedAmounts as $value) {
            if ($remainingAmount < $value) {
                continue;
            }

            $totalValidCoins = intval($remainingAmount / $value);

            for ($i = 0 ; $i < $totalValidCoins ; $i++) {
                $coins[] = new Coin($value);
                $remainingAmount -= $value;
            }
        }

        return new self($coins);
    }
}