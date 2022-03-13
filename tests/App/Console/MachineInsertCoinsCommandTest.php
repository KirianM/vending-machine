<?php

namespace VendorMachine\App\Tests\Console;

use VendorMachine\App\Tests\AcceptanceTestCase;

class MachineInsertCoinsCommandTest extends AcceptanceTestCase
{
    private const COMMAND_NAME = 'machine:coins:insert';

    /** @test */
    public function it_should_return_command_success(): void
    {
        $commandTester = $this->getCommandTester(self::COMMAND_NAME);

        $commandTester->execute([
            'command'  => self::COMMAND_NAME,
        ]);

        $commandTester->assertCommandIsSuccessful();
    }
}
