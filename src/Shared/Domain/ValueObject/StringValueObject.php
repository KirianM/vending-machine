<?php

declare(strict_types=1);

namespace VendorMachine\Shared\Domain\ValueObject;

use Stringable;

abstract class StringValueObject implements Stringable
{
    public function __construct(protected string $value)
    {
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value();
    }
}