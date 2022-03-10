<?php

namespace VendorMachine\Tests\Machine\Application;

use Symfony\Component\Console\Tester\CommandTester;
use VendorMachine\Machine\Application\MachineCoinsInserter;
use VendorMachine\Machine\Domain\MachineBalanceRepository;
use VendorMachine\Shared\Domain\Coin;
use VendorMachine\Tests\UnitTestCase;
use Mockery\MockInterface;
use VendorMachine\Machine\Domain\Balance;
use VendorMachine\Machine\Domain\MachineBalanceGetter;
use VendorMachine\Shared\Domain\Coins;
use VendorMachine\Shared\Domain\DomainError;
use VendorMachine\Shared\Domain\InvalidCoin;

class MachineCoinsInserterTest extends UnitTestCase
{
    private MachineMachineBalanceRepositoryRepository|MockInterface|null $repository;
    private MachineCoinsInserter $inserter;

    public function setUp(): void
    {
        parent::setUp();

        $coinsGetter = new MachineBalanceGetter($this->repository());
        $this->inserter = new MachineCoinsInserter($this->repository(), $coinsGetter);
    }
    /** @test */
    // public function it_should_not_throw_exceptions(): void
    // {
    //     $coins = new Coins([
    //         new Coin(0.05)
    //     ]);

    //     $balance = new Balance($coins);

    //     $this->shouldGet(new Balance(new Coins([])));
    //     $this->shouldSave($balance);

    //     $this->inserter->__invoke($coins);
    // }

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
            ->shouldReceive('get')
            ->once()
            ->andReturn($balance);
    }

    protected function shouldSave(Balance $balance): void
    {
        $this->repository()
            ->shouldReceive('save')
            ->with($balance)
            ->once()
            ->andReturnNull();
    }

    public function repository(): MachineBalanceRepository|MockInterface
    {
        return $this->repository = $this->repository ?? $this->mock(MachineBalanceRepository::class);
    }
}
