<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Balance\Domain;

use VendorMachine\Shared\Domain\DomainError;

final class NotEnoughMoney extends DomainError
{
    protected function errorMessage(): string
    {
        return 'Not enough money';
    }
}