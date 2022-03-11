<?php

declare(strict_types=1);

namespace VendorMachine\Shared\Domain;

use VendorMachine\Shared\Domain\ValueObject\FloatValueObject;

final class Coin extends FloatValueObject
{
    private const ALLOWED_AMOUNTS = [0.05, 0.10, 0.25, 1];

    public function __construct(protected float $value)
    {
        $this->ensureIsValidCoin($value);
    }

    public static function allowedAmounts(): array
    {
        return self::ALLOWED_AMOUNTS;
    }
    
    private function ensureIsValidCoin(float $value): void
    {
        $valid = false;

        foreach (self::allowedAmounts() as $allowedAmount) {
            if (FloatUtils::areEqual($allowedAmount, $value)) {
                $valid = true;
                break;
            }
        }

        if (!$valid) {
            throw new InvalidCoin();
        }
    }
}