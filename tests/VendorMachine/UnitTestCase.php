<?php

namespace VendorMachine\Tests;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use VendorMachine\App\Application;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

abstract class UnitTestCase extends TestCase
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

    protected function mock(string $className): MockObject
    {
        return $this->getMockBuilder($className)->getMock();
    }
}
