<?php

declare(strict_types=1);

namespace VendorMachine\Shared\Domain;

use VendorMachine\Shared\Domain\DomainError;

final class InvalidCoin extends DomainError
{
    protected function errorMessage(): string
    {
        return 'This coin is not allowed.';
    }
}