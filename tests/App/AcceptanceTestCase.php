<?php

namespace VendorMachine\App\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use VendorMachine\App\Application;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

abstract class AcceptanceTestCase extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $container = new ContainerBuilder();
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__));
        $loader->load('../../app/config/services.yaml');
        $loader->load('../../app/config/services_test.yaml');

        $container->compile();
        $this->application = $container->get(Application::class);
    }

    protected function getCommand(string $commandName): Command
    {
        return $this->application->find($commandName);
    }

    protected function getCommandTester(string $commandName): CommandTester
    {
        $command = $this->getCommand($commandName);
        
        return new CommandTester($command);
    }

    protected function insertCoins(array $coins): void
    {
        $commandTester = $this->getCommandTester('machine:coins:insert');

        $commandTester->execute([
            'command'   => 'machine:coins:insert',
            'coins'     => $coins,
        ]);
    }

    protected function emptyBalance(): void
    {
        $commandTester = $this->getCommandTester('machine:coins:return');

        $commandTester->execute([
            'command'   => 'machine:coins:return',
        ]);
    }

    protected function setProductStock(string $product, int $stock): void
    {
        $commandTester = $this->getCommandTester('service:products:set-stock');

        $commandTester->execute([
            'command'   => 'service:products:set-stock',
            'product'   => $product,
            'stock'     => $stock,
        ]);
    }

    protected function setChange(array $coins): void
    {
        $commandTester = $this->getCommandTester('service:change:set');

        $commandTester->execute([
            'command'   => 'service:change:set',
            'coins'     => $coins,
        ]);
    }
}
