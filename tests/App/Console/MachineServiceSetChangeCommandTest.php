<?php

namespace VendorMachine\App\Tests\Console;

use VendorMachine\App\Tests\AcceptanceTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class MachineServiceSetChangeCommandTest extends AcceptanceTestCase
{
    /** @test */
    public function it_should_return_command_success(): void
    {
        $command = $this->application->find('machine:service:set-change');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'   => $command->getName(),
            'coins'     => [
                0.25
            ],
        ]);

        $commandTester->assertCommandIsSuccessful();
    }
}
