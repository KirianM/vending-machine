<?php

namespace VendorMachine\Tests\Machine\Change\Application;

use VendorMachine\Machine\Change\Domain\MachineChangeRepository;
use VendorMachine\Tests\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use VendorMachine\Machine\Change\Domain\Change;
use VendorMachine\Machine\Change\Domain\MachineChangeGetter;
use VendorMachine\Shared\Domain\Coin;
use VendorMachine\Shared\Domain\Coins;

class MachineChangeGetterTest extends UnitTestCase
{
    private MachineChangeRepository|MockObject|null $repository;
    private MachineChangeGetter $changeGetter;

    public function setUp(): void
    {
        parent::setUp();

        $this->changeGetter = new MachineChangeGetter($this->repository());
    }
    
    /** @test */
    public function it_should_return_balance(): void
    {
        $coins = new Coins([
            new Coin(0.05),
            new Coin(0.25),
        ]);

        $change = new Change($coins);

        $this->shouldGet($change);

        $this->assertEquals($change, $this->changeGetter->__invoke());
    }

    protected function shouldGet(Change $change): void
    {
        $this->repository()
            ->expects($this->once())
            ->method('get')
            ->willReturn($change);
    }

    public function repository(): MachineChangeRepository|MockObject
    {
        return $this->repository = $this->repository ?? $this->mock(MachineChangeRepository::class);
    }
}
