<?php

namespace VendorMachine\App\Tests\Console;

use VendorMachine\App\Tests\AcceptanceTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class MachineInsertCoinsCommandTest extends AcceptanceTestCase
{
    /** @test */
    public function it_should_return_command_success(): void
    {
        $command = $this->application->find('machine:coins:insert');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'  => $command->getName(),
        ]);

        $commandTester->assertCommandIsSuccessful();
    }
}
