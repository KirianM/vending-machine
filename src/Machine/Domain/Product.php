<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Domain;

final class Product
{
    public function __construct(
        private ItemName $name,
        private ItemPrice $price,
        private ItemStock $stock
    ) {
    }

    public static function fromPrimitives(string $name, float $price, int $stock)
    {
        return new self(
            new ItemName($name),
            new ItemPrice($price),
            new ItemStock($stock)
        );
    }

    public function name(): ItemName
    {
        return $this->name;
    }

    public function price(): ItemPrice
    {
        return $this->price;
    }

    public function stock(): ItemStock
    {
        return $this->stock;
    }

    public function isInStock(): bool
    {
        return ($this->stock()->value() > 0);
    }

    public function decreaseStock(): Product
    {
        $stock = new ItemStock($this->stock()->value() - 1);

        return new self($this->name(), $this->price(), $stock);
    }
}