<?php

namespace VendorMachine\Tests\Machine\Application;

use Symfony\Component\Console\Tester\CommandTester;
use VendorMachine\Machine\Application\MachineCoinsInserter;
use VendorMachine\Machine\Domain\Balance;
use VendorMachine\Shared\Domain\Coin;
use VendorMachine\Tests\UnitTestCase;

class MachineCoinsInserterTest extends UnitTestCase
{
    private MachineCoinsInserter $inserter;

    public function setUp(): void
    {
        parent::setUp();

        $this->inserter = new MachineCoinsInserter();
    }
    /**
     * @test
     * @doesNotPerformAssertions
    */
    public function it_should_not_throw_exceptions(): void
    {
        $this->inserter->__invoke(new Balance([
            new Coin(0.05)
        ]));
    }
}
