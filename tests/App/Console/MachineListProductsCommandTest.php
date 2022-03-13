<?php

namespace VendorMachine\App\Tests\Console;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;
use VendorMachine\App\Tests\AcceptanceTestCase;

class MachineListProductsCommandTest extends AcceptanceTestCase
{
    private const COMMAND_NAME = 'machine:products:list';

    /** @test */
    public function it_should_output_a_list_of_the_available_products(): void
    {
        $this->setProductStock('Water', 1);
        $this->setProductStock('Juice', 1);
        $this->setProductStock('Soda', 1);

        $commandExpectedOutput = <<< EOT
        +-------+-------+-------+
        | Name  | Price | Stock |
        +-------+-------+-------+
        | Water | 0.65  | 1     |
        | Juice | 1     | 1     |
        | Soda  | 1.5   | 1     |
        +-------+-------+-------+
        EOT;

        $commandTester = $this->getCommandTester(self::COMMAND_NAME);
        $commandTester->execute([
            'command'   => self::COMMAND_NAME,
        ]);

        $commandTester->assertCommandIsSuccessful();

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString($commandExpectedOutput, $output);
    }
}
