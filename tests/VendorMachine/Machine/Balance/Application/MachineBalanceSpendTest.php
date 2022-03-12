<?php

namespace VendorMachine\Tests\Machine\Balance\Application;

use VendorMachine\Machine\Balance\Domain\MachineBalanceRepository;
use VendorMachine\Tests\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use VendorMachine\Machine\Balance\Domain\Balance;
use VendorMachine\Machine\Balance\Domain\MachineBalanceGetter;
use VendorMachine\Machine\Balance\Domain\MachineBalanceSpend;
use VendorMachine\Machine\Change\Domain\Change;
use VendorMachine\Machine\Change\Domain\MachineChangeGetter;
use VendorMachine\Machine\Change\Domain\MachineChangeRepository;
use VendorMachine\Machine\Change\Domain\MachineChangeSetter;
use VendorMachine\Shared\Domain\Coins;

class MachineBalanceSpendTest extends UnitTestCase
{
    private MachineBalanceRepository|MockObject|null $repository;
    private MachineChangeRepository|MockObject|null $changeRepository;

    private MachineBalanceGetter $balanceGetter;
    private MachineBalanceSpend $balanceSpend;

    private MachineChangeGetter $changeGetter;
    private MachineChangeSetter $changeSetter;

    public function setUp(): void
    {
        parent::setUp();

        $this->changeGetter = new MachineChangeGetter($this->changeRepository());
        $this->changeSetter = new MachineChangeSetter($this->changeRepository());

        $this->balanceGetter = new MachineBalanceGetter($this->balanceRepository());
        $this->balanceSpend = new MachineBalanceSpend($this->balanceRepository(), $this->balanceGetter, $this->changeGetter, $this->changeSetter);
    }

    /** @test */
    public function it_should_return_empty_coins_when_exact_change(): void
    {
        $productCost = 0.65;

        $this->balanceRepository()
            ->expects($this->once())
            ->method('get')
            ->willReturn(new Balance(Coins::fromArray([0.25, 0.25, 0.1, 0.05])));

        $coins = $this->balanceSpend->__invoke($productCost);

        $this->assertEquals(Coins::empty(), $coins);
    }

    /** @test */
    public function it_should_return_change_coins_when_not_exact_change(): void
    {
        $productCost = 0.65;

        $balanceCoins = Coins::fromArray([0.25, 0.25, 0.1, 0.1]);

        $this->balanceRepository()
            ->expects($this->once())
            ->method('get')
            ->willReturn(new Balance($balanceCoins));

        $changeCoins = Coins::fromArray([0.05]);

        $this->changeRepository()
            ->expects($this->once())
            ->method('get')
            ->willReturn(new Change($changeCoins));

        $this->changeRepository()
            ->expects($this->once())
            ->method('save')
            ->with(new Change($balanceCoins));

        $this->balanceRepository()
            ->expects($this->once())
            ->method('save')
            ->with(new Balance(Coins::empty()));

        $coins = $this->balanceSpend->__invoke($productCost);

        $this->assertEquals(Coins::fromArray([0.05]), $coins);
    }

    public function balanceRepository(): MachineBalanceRepository|MockObject
    {
        return $this->repository = $this->repository ?? $this->mock(MachineBalanceRepository::class);
    }

    public function changeRepository(): MachineChangeRepository|MockObject
    {
        return $this->changeRepository = $this->changeRepository ?? $this->mock(MachineChangeRepository::class);
    }
}
