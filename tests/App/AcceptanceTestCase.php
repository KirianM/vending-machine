<?php

namespace VendorMachine\App\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use VendorMachine\App\Application;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class AcceptanceTestCase extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $container = new ContainerBuilder();
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__));
        $loader->load('../../config/services.yaml');
        $loader->load('../../config/services_test.yaml');

        $container->compile();
        $this->application = $container->get(Application::class);
    }
}
