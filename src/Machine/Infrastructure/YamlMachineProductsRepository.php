<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Infrastructure;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;
use VendorMachine\Machine\Domain\Balance;
use VendorMachine\Machine\Domain\BalanceLeft;
use VendorMachine\Machine\Domain\Product;
use VendorMachine\Machine\Domain\ItemName;
use VendorMachine\Machine\Domain\MachineRepository;
use VendorMachine\Shared\Domain\Coins;

final class YamlMachineProductsRepository implements MachineRepository
{
    private const FILENAME = 'machine_state.yaml';
    private const CHANGE = 'change';
    private const BALANCE = 'balance';
    private const BALANCE_LEFT = 'balance_left';
    private const ITEMS = 'items';

    private Filesystem $filesystem;
    private array $machineState;

    public function __construct()
    {
        $this->filesystem = new Filesystem();

        $this->load();
    }

    public function currentChange(): Coins
    {
        return Coins::fromArray($this->machineState[self::CHANGE]);
    }

    public function currentBalance(): Balance
    {
        return new Balance(
            Coins::fromArray($this->machineState[self::BALANCE]),
            new BalanceLeft($this->machineState[self::BALANCE_LEFT])
        );
    }

    public function balanceLeft(): BalanceLeft
    {
        return new BalanceLeft($this->machineState[self::BALANCE_LEFT]);
    }
    
    public function insertCoins(Coins $coins): void
    {
        $currentCoins = $this->currentBalance()->coins()->toArray();
        $this->machineState[self::BALANCE] = array_merge($currentCoins, $coins->toArray());

        $this->persist();
    }

    public function emptyBalance(): void
    {
        $this->machineState[self::BALANCE_LEFT] = 0;
        $this->machineState[self::BALANCE] = [];

        $this->persist();
    }

    public function getProduct(ItemName $name): ?Product
    {
        $itemIndex = $this->getProductIndex($name->value());

        if ($itemIndex === false) {
            return null;
        }

        $item = $this->machineState[self::ITEMS][$itemIndex];
        
        return Product::fromPrimitives($item['name'], $item['price'], $item['stock']);
    }

    public function saveProduct(Product $item): void
    {
        $itemIndex = $this->getProductIndex($item->name()->value());

        if ($itemIndex === false) {
            throw new \RuntimeException('Product not found');
        }

        $this->machineState[self::ITEMS][$itemIndex] = [
            'name'  => $item->name()->value(),
            'price' => $item->price()->value(),
            'stock' => $item->stock()->value(),
        ];

        $this->persist();
    }

    private function getProductIndex(string $name): ?int
    {
        $itemIndex = array_search($name, array_column($this->machineState[self::ITEMS], 'name'));

        if ($itemIndex === false) {
            return null;
        }

        return $itemIndex;
    }

    private function load(): void
    {
        if (!$this->filesystem->exists($this->getFilepath())) {
            $this->machineState = [
                self::CHANGE => [],
                self::BALANCE => [],
                self::BALANCE_LEFT => 0,
                'items' => [
                    ['name' => 'Water', 'price' => 0.65, 'stock' => 10],
                    ['name' => 'Juice', 'price' => 1.00, 'stock' => 10],
                    ['name' => 'Soda', 'price' => 1.5, 'stock' => 10],
                ]
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