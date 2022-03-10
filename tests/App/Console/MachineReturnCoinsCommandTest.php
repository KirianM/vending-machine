<?php

namespace VendorMachine\App\Tests\Console;

use VendorMachine\App\Tests\AcceptanceTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class MachineReturnCoinsCommandTest extends AcceptanceTestCase
{
    /** @test */
    public function it_should_output_a_list_of_the_returned_coins(): void
    {
        $this->insertDummyCoins();

        $command = $this->application->find('machine:coins:return');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'   => $command->getName(),
        ]);

        $commandTester->assertCommandIsSuccessful();

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('0.25, 0.1, 0.1', $output);
    }

    private function insertDummyCoins(): void
    {
        $command = $this->application->find('machine:coins:insert');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'   => $command->getName(),
            'coins'     => [
                0.25,
                0.1,
                0.1,
            ],
        ]);
    }
}
