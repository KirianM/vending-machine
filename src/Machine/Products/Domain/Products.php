<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Products\Domain;

use VendorMachine\Shared\Domain\Collection;

final class Products extends Collection
{
    protected function type(): string
    {
        return Product::class;
    }
}