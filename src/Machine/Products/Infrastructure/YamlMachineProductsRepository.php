<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Products\Infrastructure;

use VendorMachine\Machine\Products\Domain\Product;
use VendorMachine\Machine\Products\Domain\ProductName;
use VendorMachine\Machine\Products\Domain\MachineProductsRepository;
use VendorMachine\Machine\Products\Domain\Products;
use VendorMachine\Shared\Infrastructure\YamlMachineRepository;

final class YamlMachineProductsRepository extends YamlMachineRepository implements MachineProductsRepository
{
    private const PRODUCTS = 'products';

    protected function entityFilepath(): string
    {
        return 'machine/products.yaml';
    }

    protected function dummyEntity(): mixed
    {
        return [self::PRODUCTS => [
            ['name' => 'Water', 'price' => 0.65, 'stock' => 10],
            ['name' => 'Juice', 'price' => 1.00, 'stock' => 10],
            ['name' => 'Soda', 'price' => 1.5, 'stock' => 10],
        ]];
    }

    public function search(ProductName $name): ?Product
    {
        $itemIndex = $this->getProductIndex($name->value());

        if ($itemIndex === false) {
            return null;
        }

        $item = $this->entityState[self::PRODUCTS][$itemIndex];
        
        return Product::fromPrimitives($item['name'], $item['price'], $item['stock']);
    }

    public function all(): Products
    {
        return new Products(array_map(function ($product) {
            return Product::fromPrimitives($product['name'], $product['price'], $product['stock']);
        }, $this->entityState[self::PRODUCTS]));
    }

    public function save(Product $item): void
    {
        $itemIndex = $this->getProductIndex($item->name()->value());

        if ($itemIndex === false) {
            throw new \RuntimeException('Product not found');
        }

        $this->entityState[self::PRODUCTS][$itemIndex] = [
            'name'  => $item->name()->value(),
            'price' => $item->price()->value(),
            'stock' => $item->stock()->value(),
        ];

        $this->persist();
    }

    private function getProductIndex(string $name): ?int
    {
        $itemIndex = array_search($name, array_column($this->entityState[self::PRODUCTS], 'name'));

        if ($itemIndex === false) {
            return null;
        }

        return $itemIndex;
    }
}