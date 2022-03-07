<?php

declare(strict_types=1);

namespace VendorMachine\Shared\Domain;

use VendorMachine\Shared\Domain\ValueObject\FloatValueObject;

final class Coin extends FloatValueObject
{
    private const ALLOWED_AMOUNTS = [0.05, 0.10, 0.25, 1];
    private const EPSILON = 0.00001;

    public function __construct(protected float $value)
    {
        $this->ensureIsValidCoin($value);
    }
    
    private function ensureIsValidCoin(float $value): void
    {
        $valid = false;

        foreach (self::ALLOWED_AMOUNTS as $allowedAmount) {
            if (abs($allowedAmount - $value) < self::EPSILON) {
                $valid = true;
                break;
            }
        }

        if (!$valid) {
            throw new InvalidCoin();
        }
    }
}