<?php

namespace VendorMachine\App\Tests\Console;

use VendorMachine\App\Tests\AcceptanceTestCase;

class MachineServiceSetProductStockCommandTest extends AcceptanceTestCase
{
    private const COMMAND_NAME = 'service:products:set-stock';

    /** @test */
    public function it_should_return_command_success(): void
    {
        $commandTester = $this->getCommandTester(self::COMMAND_NAME);

        $commandTester->execute([
            'command'   => self::COMMAND_NAME,
            'product'   => 'Water',
            'stock'     => 10,
        ]);

        $commandTester->assertCommandIsSuccessful();
    }
}
