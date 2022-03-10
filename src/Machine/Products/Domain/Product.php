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
        return ($this->stock()->value() > 0);
    }

    public function decreaseStock(): Product
    {
        $stock = new ProductStock($this->stock()->value() - 1);

        return new self($this->name(), $this->price(), $stock);
    }
}