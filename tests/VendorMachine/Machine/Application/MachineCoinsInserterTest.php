<?php

namespace VendorMachine\Tests\Machine\Application;

use Symfony\Component\Console\Tester\CommandTester;
use VendorMachine\Machine\Application\MachineCoinsInserter;
use VendorMachine\Machine\Domain\MachineRepository;
use VendorMachine\Shared\Domain\Coin;
use VendorMachine\Tests\UnitTestCase;
use Mockery\MockInterface;
use VendorMachine\Shared\Domain\Coins;

class MachineCoinsInserterTest extends UnitTestCase
{
    private MachineRepository|MockInterface|null $repository;
    private MachineCoinsInserter $inserter;

    public function setUp(): void
    {
        parent::setUp();

        $this->inserter = new MachineCoinsInserter($this->repository());
    }
    /** @test */
    public function it_should_not_throw_exceptions(): void
    {
        $coins = new Coins([
            new Coin(0.05)
        ]);

        $this->repository()
            ->shouldReceive('updateBalance')
            ->with($coins)
            ->once()
            ->andReturnNull();

        $this->inserter->__invoke($coins);
    }

    public function repository(): MachineRepository|MockInterface
    {
        return $this->repository = $this->repository ?? $this->mock(MachineRepository::class);
    }
}
