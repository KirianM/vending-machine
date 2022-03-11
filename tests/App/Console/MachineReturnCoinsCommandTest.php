<?php

namespace VendorMachine\App\Tests\Console;

use VendorMachine\App\Tests\AcceptanceTestCase;

class MachineReturnCoinsCommandTest extends AcceptanceTestCase
{
    private const COMMAND_NAME = 'machine:coins:return';

    /** @test */
    public function it_should_output_a_list_of_the_returned_coins(): void
    {
        $this->insertCoins([
            0.25,
            0.1,
            0.1,
        ]);

        $commandTester = $this->getCommandTester(self::COMMAND_NAME);
        
        $commandTester->execute([
            'command'   => self::COMMAND_NAME,
        ]);

        $commandTester->assertCommandIsSuccessful();

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('0.25, 0.1, 0.1', $output);
    }
}
