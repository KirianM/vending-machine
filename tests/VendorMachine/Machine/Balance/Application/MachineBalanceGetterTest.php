<?php

namespace VendorMachine\Tests\Machine\Balance\Application;

use VendorMachine\Machine\Balance\Domain\MachineBalanceRepository;
use VendorMachine\Tests\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use VendorMachine\Machine\Balance\Domain\Balance;
use VendorMachine\Machine\Balance\Domain\MachineBalanceGetter;
use VendorMachine\Shared\Domain\Coin;
use VendorMachine\Shared\Domain\Coins;

class MachineBalanceGetterTest extends UnitTestCase
{
    private MachineBalanceRepository|MockObject|null $repository;
    private MachineBalanceGetter $balanceGetter;

    public function setUp(): void
    {
        parent::setUp();

        $this->balanceGetter = new MachineBalanceGetter($this->repository());
    }
    
    /** @test */
    public function it_should_return_balance(): void
    {
        $coins = new Coins([
            new Coin(0.05),
            new Coin(0.25),
        ]);

        $balance = new Balance($coins);

        $this->shouldGet($balance);

        $this->assertEquals($balance, $this->balanceGetter->__invoke());
    }

    protected function shouldGet(Balance $balance): void
    {
        $this->repository()
            ->expects($this->once())
            ->method('get')
            ->willReturn($balance);
    }

    public function repository(): MachineBalanceRepository|MockObject
    {
        return $this->repository = $this->repository ?? $this->mock(MachineBalanceRepository::class);
    }
}
