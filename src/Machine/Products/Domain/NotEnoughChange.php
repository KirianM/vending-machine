<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Products\Domain;

use VendorMachine\Shared\Domain\DomainError;

final class NotEnoughChange extends DomainError
{
    protected function errorMessage(): string
    {
        return 'Not enough change';
    }
}