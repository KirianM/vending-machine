<?php

namespace VendorMachine\App\Tests\Console;

use VendorMachine\App\Tests\AcceptanceTestCase;

class MachineBuyProductCommandTest extends AcceptanceTestCase
{
    private const COMMAND_NAME = 'machine:products:buy';

    /** @test */
    public function it_should_output_the_name_of_the_product_selected(): void
    {
        $this->setProductStock('Water', 1);
        $this->emptyBalance();
        $this->insertCoins($this->getEnoughCoinsToBuyWater());

        $commandTester = $this->getCommandTester(self::COMMAND_NAME);
        $commandTester->execute([
            'command'   => self::COMMAND_NAME,
            'name'      => 'Water',
        ]);

        $commandTester->assertCommandIsSuccessful();

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Water', $output);
    }

    /** @test */
    public function it_should_output_out_of_stock_when_product_is_out(): void
    {
        $this->setProductStock('Water', 0);
        $this->emptyBalance();
        $this->insertCoins($this->getEnoughCoinsToBuyWater());

        $commandTester = $this->getCommandTester(self::COMMAND_NAME);
        $commandTester->execute([
            'command'   => self::COMMAND_NAME,
            'name'      => 'Water',
        ]);

        $commandTester->assertCommandIsSuccessful();

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Product <Water> is out of stock', $output);
    }

    /** @test */
    public function it_should_output_not_enough_money(): void
    {
        $this->setProductStock('Water', 1);
        $this->emptyBalance();
        $this->insertCoins($this->getNotEnoughCoinsToBuyWater());

        $commandTester = $this->getCommandTester(self::COMMAND_NAME);
        $commandTester->execute([
            'command'   => self::COMMAND_NAME,
            'name'      => 'Water',
        ]);

        $commandTester->assertCommandIsSuccessful();

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Current balance is not enough to buy <Water>', $output);
    }

    /** @test */
    public function it_should_output_product_selected_and_change(): void
    {
        $this->setChange([
            0.25,
            0.1,
            0.05,
        ]);
        $this->setProductStock('Water', 1);
        $this->emptyBalance();
        $this->insertCoins([
            1,
            0.05,
        ]);

        $commandTester = $this->getCommandTester(self::COMMAND_NAME);
        $commandTester->execute([
            'command'   => self::COMMAND_NAME,
            'name'      => 'Water',
        ]);

        $commandTester->assertCommandIsSuccessful();

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Water 0.25, 0.1, 0.05', $output);
    }

    private function getEnoughCoinsToBuyWater(): array
    {
        return [
            0.25,
            0.25,
            0.1,
            0.05
        ];
    }

    private function getNotEnoughCoinsToBuyWater(): array
    {
        return [
            0.25,
        ];
    }
}
