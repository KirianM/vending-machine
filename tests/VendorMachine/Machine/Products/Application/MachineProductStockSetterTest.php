<?php

namespace VendorMachine\Tests\Machine\Products\Application;

use VendorMachine\Tests\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use VendorMachine\Machine\Products\Application\MachineProductStockSetter;
use VendorMachine\Machine\Products\Domain\MachineProductsRepository;
use VendorMachine\Machine\Products\Domain\Product;
use VendorMachine\Machine\Products\Domain\ProductName;
use VendorMachine\Machine\Products\Domain\ProductPrice;
use VendorMachine\Machine\Products\Domain\ProductStock;

class MachineProductStockSetterTest extends UnitTestCase
{
    private MachineProductsRepository|MockObject|null $repository;
    private MachineProductStockSetter $productStock;

    public function setUp(): void
    {
        parent::setUp();

        $this->productStock = new MachineProductStockSetter($this->repository());
    }
    
    /** @test */
    public function it_should_set_product_stock(): void
    {
        $product = new Product(
            new ProductName('Water'),
            new ProductPrice(0.65),
            new ProductStock(10)
        );

        $this->shouldSearch($product->name(), $product);
        $this->shouldSave($product);

        $this->productStock->__invoke($product->name(), $product->stock());
    }

    protected function shouldSearch(ProductName $productName, Product $product): void
    {
        $this->repository()
            ->expects($this->once())
            ->method('search')
            ->willReturn($product);
    }

    protected function shouldSave(Product $product): void
    {
        $this->repository()
            ->expects($this->once())
            ->method('save')
            ->with($product);
    }

    public function repository(): MachineProductsRepository|MockObject
    {
        return $this->repository = $this->repository ?? $this->mock(MachineProductsRepository::class);
    }
}
