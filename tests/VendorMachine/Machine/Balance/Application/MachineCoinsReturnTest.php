<?php

namespace VendorMachine\Tests\Machine\Balance\Application;

use VendorMachine\Machine\Balance\Domain\MachineBalanceRepository;
use VendorMachine\Shared\Domain\Coin;
use VendorMachine\Tests\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use VendorMachine\Machine\Balance\Application\MachineCoinsReturn;
use VendorMachine\Machine\Balance\Domain\Balance;
use VendorMachine\Machine\Balance\Domain\MachineBalanceGetter;
use VendorMachine\Shared\Domain\Coins;
use VendorMachine\Shared\Domain\InvalidCoin;

class MachineCoinsReturnTest extends UnitTestCase
{
    private MachineBalanceRepository|MockObject|null $repository;
    private MachineCoinsReturn $coinsReturn;

    public function setUp(): void
    {
        parent::setUp();

        $coinsGetter = new MachineBalanceGetter($this->repository());
        $this->coinsReturn = new MachineCoinsReturn($this->repository(), $coinsGetter);
    }
    
    /** @test */
    public function it_should_return_balance_coins(): void
    {
        $coins = new Coins([
            new Coin(0.05),
            new Coin(0.25),
        ]);

        $balance = new Balance($coins);

        $this->shouldGet($balance);
        $this->shouldSave(new Balance(new Coins([])));

        $this->assertEquals($coins, $this->coinsReturn->__invoke());
    }

    protected function shouldGet(Balance $balance): void
    {
        $this->repository()
            ->expects($this->once())
            ->method('get')
            ->willReturn($balance);
    }

    protected function shouldSave(Balance $balance): void
    {
        $this->repository()
            ->expects($this->once())
            ->method('save')
            ->with($balance);
    }

    public function repository(): MachineBalanceRepository|MockObject
    {
        return $this->repository = $this->repository ?? $this->mock(MachineBalanceRepository::class);
    }
}
