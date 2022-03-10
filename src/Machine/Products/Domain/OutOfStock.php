<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Products\Domain;

use VendorMachine\Shared\Domain\DomainError;

final class OutOfStock extends DomainError
{
    protected function errorMessage(): string
    {
        return 'Out of stock';
    }
}