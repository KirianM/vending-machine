<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Infrastructure;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;
use VendorMachine\Machine\Domain\MachineRepository;
use VendorMachine\Shared\Domain\Coins;

final class YamlMachineRepository implements MachineRepository
{
    private const FILENAME = 'machine_state.yaml';
    private const BALANCE = 'balance';

    private Filesystem $filesystem;
    private array $machineState;

    public function __construct()
    {
        $this->filesystem = new Filesystem();

        $this->load();
    }

    public function currentBalance(): Coins
    {
        return Coins::fromArray($this->machineState[self::BALANCE]);
    }
    
    public function insertCoins(Coins $coins): void
    {
        $this->machineState[self::BALANCE] = array_merge($this->currentBalance()->toArray(), $coins->toArray());

        $this->persist();
    }

    public function emptyBalance(): void
    {
        $this->machineState[self::BALANCE] = [];

        $this->persist();
    }

    private function load(): void
    {
        if (!$this->filesystem->exists($this->getFilepath())) {
            $this->machineState = [
                self::BALANCE => [],
            ];
            
            $this->persist();
        }

        $this->machineState = Yaml::parseFile($this->getFilepath());
    }

    private function persist(): void
    {
        $this->filesystem->dumpFile($this->getFilepath(), Yaml::dump($this->machineState));
    }

    private function getFilepath(): string
    {
        return self::FILENAME;
    }
}