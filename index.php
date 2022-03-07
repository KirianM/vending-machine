#!/usr/bin/env php
<?php // application.php

require __DIR__ . '/vendor/autoload.php';

use VendorMachine\App\Application;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

$container = new ContainerBuilder();
$loader = new YamlFileLoader($container, new FileLocator(__DIR__));
$loader->load('config/services.yaml');

$container->compile();
$container->get(Application::class)->run();
