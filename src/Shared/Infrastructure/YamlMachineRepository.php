<?php

declare(strict_types=1);

namespace VendorMachine\Shared\Infrastructure;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;
use VendorMachine\Machine\Balance\Domain\Balance;
use VendorMachine\Machine\Domain\BalanceLeft;
use VendorMachine\Machine\Product\Domain\Product;
use VendorMachine\Machine\Product\Domain\ProductName;
use VendorMachine\Shared\Domain\Coins;

abstract class YamlMachineRepository
{
    protected $entityState;

    private Filesystem $filesystem;

    public function __construct()
    {
        $this->filesystem = new Filesystem();
        $this->init();
    }

    abstract protected function entityFilepath(): string;

    abstract protected function dummyEntity(): mixed;

    private function init(): void
    {
        $this->filesystem->mkdir(dirname($this->entityFilepath()));

        if (!$this->filesystem->exists($this->entityFilepath())) {
            $this->entityState = $this->dummyEntity();
            
            $this->persist();
        } else {
            $this->load();
        }
    }

    private function load(): void
    {
        $this->entityState = Yaml::parseFile($this->entityFilepath());
    }

    protected function persist(): void
    {
        $this->filesystem->dumpFile($this->entityFilepath(), Yaml::dump($this->entityState));
    }
}