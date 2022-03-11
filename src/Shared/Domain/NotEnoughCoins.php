<?php

declare(strict_types=1);

namespace VendorMachine\Shared\Domain;

use VendorMachine\Shared\Domain\DomainError;

final class NotEnoughCoins extends DomainError
{
    protected function errorMessage(): string
    {
        return 'There are not enough coins to sum this amount.';
    }
}