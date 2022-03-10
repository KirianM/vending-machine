<?php

namespace VendorMachine\App\Tests\Console;

use VendorMachine\App\Tests\AcceptanceTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class MachineBuyProductCommandTest extends AcceptanceTestCase
{
    /** @test */
    public function it_should_output_the_name_of_the_product_selected(): void
    {
        $this->insertDummyCoins();

        $command = $this->application->find('machine:products:buy');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'   => $command->getName(),
            'name'      => 'Water',
        ]);

        $commandTester->assertCommandIsSuccessful();

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Water', $output);
    }

    /** @test */
    public function it_should_output_out_of_stock_when_product_is_out(): void
    {
        $this->insertDummyCoins();

        $command = $this->application->find('machine:products:buy');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'   => $command->getName(),
            'name'      => 'Water',
        ]);

        $commandTester->assertCommandIsSuccessful();

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Out of stock', $output);
    }

    private function insertDummyCoins(): void
    {
        $command = $this->application->find('machine:coins:insert');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'   => $command->getName(),
            'coins'     => [
                0.25,
                0.25,
                0.1,
                0.05
            ],
        ]);
    }
}
