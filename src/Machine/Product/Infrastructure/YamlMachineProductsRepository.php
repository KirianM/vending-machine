<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Product\Infrastructure;

use VendorMachine\Machine\Product\Domain\Product;
use VendorMachine\Machine\Product\Domain\ProductName;
use VendorMachine\Machine\Product\Domain\MachineProductsRepository;
use VendorMachine\Shared\Infrastructure\YamlMachineRepository;

final class YamlMachineProductsRepository extends YamlMachineRepository implements MachineProductsRepository
{
    protected function entityFilepath(): string
    {
        return 'machine/products.yaml';
    }

    protected function dummyEntity(): mixed
    {
        return [
            ['name' => 'Water', 'price' => 0.65, 'stock' => 10],
            ['name' => 'Juice', 'price' => 1.00, 'stock' => 10],
            ['name' => 'Soda', 'price' => 1.5, 'stock' => 10],
        ];
    }

    public function search(ProductName $name): ?Product
    {
        $itemIndex = $this->getProductIndex($name->value());

        if ($itemIndex === false) {
            return null;
        }

        $item = $this->entityState[$itemIndex];
        
        return Product::fromPrimitives($item['name'], $item['price'], $item['stock']);
    }

    public function save(Product $item): void
    {
        $itemIndex = $this->getProductIndex($item->name()->value());

        if ($itemIndex === false) {
            throw new \RuntimeException('Product not found');
        }

        $this->entityState[$itemIndex] = [
            'name'  => $item->name()->value(),
            'price' => $item->price()->value(),
            'stock' => $item->stock()->value(),
        ];

        $this->persist();
    }

    private function getProductIndex(string $name): ?int
    {
        $itemIndex = array_search($name, array_column($this->entityState, 'name'));

        if ($itemIndex === false) {
            return null;
        }

        return $itemIndex;
    }
}