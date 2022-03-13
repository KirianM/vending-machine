<?php

namespace VendorMachine\Tests\Machine\Balance\Application;

use VendorMachine\Machine\Balance\Application\MachineCoinsInserter;
use VendorMachine\Machine\Balance\Domain\MachineBalanceRepository;
use VendorMachine\Shared\Domain\Coin;
use VendorMachine\Tests\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use VendorMachine\Machine\Balance\Domain\Balance;
use VendorMachine\Machine\Balance\Domain\MachineBalanceGetter;
use VendorMachine\Shared\Domain\Coins;
use VendorMachine\Shared\Domain\InvalidCoin;

class MachineCoinsInserterTest extends UnitTestCase
{
    private MachineBalanceRepository|MockObject|null $repository;
    private MachineCoinsInserter $inserter;

    public function setUp(): void
    {
        parent::setUp();

        $coinsGetter = new MachineBalanceGetter($this->repository());
        $this->inserter = new MachineCoinsInserter($this->repository(), $coinsGetter);
    }
    /** @test */
    public function it_should_not_throw_exceptions(): void
    {
        $coins = new Coins([
            new Coin(0.05)
        ]);

        $balance = new Balance($coins);

        $this->shouldGet(new Balance(new Coins([])));
        $this->shouldSave($balance);

        $this->inserter->__invoke($coins);
    }

    /** @test */
    public function it_should_throw_an_exception_when_coin_amount_is_not_allowed(): void
    {
        $this->expectException(InvalidCoin::class);

        $coins = new Coins([
            new Coin(0.2)
        ]);
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
