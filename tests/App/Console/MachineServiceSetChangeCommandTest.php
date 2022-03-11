<?php

namespace VendorMachine\App\Tests\Console;

use VendorMachine\App\Tests\AcceptanceTestCase;

class MachineServiceSetChangeCommandTest extends AcceptanceTestCase
{
    private const COMMAND_NAME = 'service:change:set';

    /** @test */
    public function it_should_return_command_success(): void
    {
        $commandTester = $this->getCommandTester(self::COMMAND_NAME);

        $commandTester->execute([
            'command'   => self::COMMAND_NAME,
            'coins'     => [
                0.25
            ],
        ]);

        $commandTester->assertCommandIsSuccessful();
    }
}
