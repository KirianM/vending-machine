<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Products\Domain;

final class Product
{
    public function __construct(
        private ProductName $name,
        private ProductPrice $price,
        private ProductStock $stock
    ) {
    }

    public static function fromPrimitives(string $name, float $price, int $stock)
    {
        return new self(
            new ProductName($name),
            new ProductPrice($price),
            new ProductStock($stock)
        );
    }

    public function name(): ProductName
    {
        return $this->name;
    }

    public function price(): ProductPrice
    {
        return $this->price;
    }

    public function stock(): ProductStock
    {
        return $this->stock;
    }

    public function isInStock(): bool
    {
        return $this->stock()->greaterThan(0);
    }

    public function changeStock(ProductStock $stock): void
    {
        $this->stock = $stock;
    }

    public function decreaseStock(int $amount = 1): void
    {
        $this->stock = $this->stock()->decrease($amount);
    }
}