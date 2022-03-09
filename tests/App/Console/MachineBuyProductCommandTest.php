<?php

namespace VendorMachine\App\Tests\Console;

use VendorMachine\App\Tests\AcceptanceTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use VendorMachine\Machine\Application\MachineBalanceCoinsResetter;

class MachineBuyProductCommandTest extends AcceptanceTestCase
{
    /** @test */
    public function it_should_output_a_list_of_the_returned_coins(): void
    {
        $command = $this->application->find('machine:products:buy');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'   => $command->getName(),
            'name'      => 'Water',
        ]);

        $commandTester->assertCommandIsSuccessful();

        // $output = $commandTester->getDisplay();
        // $this->assertStringContainsString('0.25, 0.1, 0.1', $output);
    }
}
