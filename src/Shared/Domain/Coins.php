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

    public function total(): float
    {
        return array_sum(array_map(function ($coin) {
            return $coin->value();
        }, $this->items()));
    }
}