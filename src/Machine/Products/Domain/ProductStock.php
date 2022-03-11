<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Products\Domain;

use VendorMachine\Shared\Domain\ValueObject\IntegerValueObject;

final class ProductStock extends IntegerValueObject
{
    public function decrease(int $amount = 1): self
    {
        return new self($this->value() - $amount);
    }

    public function greaterThan(int $amount): bool
    {
        return ($this->value() > $amount);
    }
}