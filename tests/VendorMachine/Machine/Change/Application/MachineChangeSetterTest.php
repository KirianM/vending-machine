<?php

namespace VendorMachine\Tests\Machine\Change\Application;

use VendorMachine\Machine\Change\Domain\MachineChangeRepository;
use VendorMachine\Tests\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use VendorMachine\Machine\Change\Domain\Change;
use VendorMachine\Machine\Change\Domain\MachineChangeSetter;
use VendorMachine\Shared\Domain\Coin;
use VendorMachine\Shared\Domain\Coins;

class MachineChangeSetterTest extends UnitTestCase
{
    private MachineChangeRepository|MockObject|null $repository;
    private MachineChangeSetter $changeGetter;

    public function setUp(): void
    {
        parent::setUp();

        $this->changeSetter = new MachineChangeSetter($this->repository());
    }
    
    /** @test */
    public function it_should_save_change(): void
    {
        $coins = new Coins([
            new Coin(0.05),
            new Coin(0.25),
        ]);

        $change = new Change($coins);

        $this->shouldGet($change);
        $this->shouldSave($change);

        $this->changeSetter->__invoke($change->coins());
    }

    protected function shouldGet(Change $change): void
    {
        $this->repository()
            ->expects($this->once())
            ->method('get')
            ->willReturn($change);
    }

    protected function shouldSave(Change $change): void
    {
        $this->repository()
            ->expects($this->once())
            ->method('save')
            ->with($change);
    }

    public function repository(): MachineChangeRepository|MockObject
    {
        return $this->repository = $this->repository ?? $this->mock(MachineChangeRepository::class);
    }
}
