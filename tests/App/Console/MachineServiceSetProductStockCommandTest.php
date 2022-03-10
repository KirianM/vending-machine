<?php

namespace VendorMachine\App\Tests\Console;

use VendorMachine\App\Tests\AcceptanceTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class MachineServiceSetProductStockCommandTest extends AcceptanceTestCase
{
    /** @test */
    public function it_should_return_command_success(): void
    {
        $command = $this->application->find('machine:service:set-product-stock');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'   => $command->getName(),
            'product'   => 'Water',
            'stock'     => 10,
        ]);

        $commandTester->assertCommandIsSuccessful();
    }
}
