<?php

namespace VendorMachine\App\Tests\Console;

use VendorMachine\App\Tests\AcceptanceTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use VendorMachine\Machine\Balance\Domain\MachineBalanceRepository;
use VendorMachine\Shared\Domain\Coins;

class MachineBuyProductCommandTest extends AcceptanceTestCase
{
    private const COMMAND_NAME = 'machine:coins:insert';

    /** @test */
    public function it_should_output_the_name_of_the_product_selected(): void
    {
        $this->setProductStock('Water', 1);
        $this->emptyBalance();
        $this->insertCoins($this->getEnoughCoinsToBuyWater());

        $command = $this->application->find('machine:products:buy');
        $commandTester = new CommandTester($command);
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

        $commandTester = $this->getCommandTester();
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

        $commandTester = $this->getCommandTester();
        $commandTester->execute([
            'command'   => self::COMMAND_NAME,
            'name'      => 'Water',
        ]);

        $commandTester->assertCommandIsSuccessful();

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Current balance is not enough to buy <Water>', $output);
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

    private function insertCoins(array $coins): void
    {
        $command = $this->application->find(self::COMMAND_NAME);
        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'command'   => $command->getName(),
            'coins'     => $coins,
        ]);
    }

    private function getCommandTester(): CommandTester
    {
        $command = $this->application->find('machine:products:buy');

        return new CommandTester($command);
    }

    private function emptyBalance(): void
    {
        $command = $this->application->find('machine:coins:return');
        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'command'   => $command->getName(),
        ]);
    }

    private function setProductStock(string $product, int $stock): void
    {
        $command = $this->application->find('service:products:set-stock');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'   => $command->getName(),
            'product'   => $product,
            'stock'     => $stock,
        ]);
    }
}
