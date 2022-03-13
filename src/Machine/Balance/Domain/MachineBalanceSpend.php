<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Balance\Domain;

use VendorMachine\Machine\Change\Domain\MachineChangeGetter;
use VendorMachine\Machine\Change\Domain\MachineChangeSetter;
use VendorMachine\Machine\Products\Domain\NotEnoughChange;
use VendorMachine\Shared\Domain\Coins;
use VendorMachine\Shared\Domain\FloatUtils;
use VendorMachine\Shared\Domain\NotEnoughCoins;

final class MachineBalanceSpend
{
    public function __construct(
        private MachineBalanceRepository $repository,
        private MachineBalanceGetter $balanceGetter,
        private MachineChangeGetter $changeBoxGetter,
        private MachineChangeSetter $changeBoxSetter
    ) { 
    }

    public function __invoke(float $amount): Coins
    {
        $balance = $this->balanceGetter->__invoke();

        $this->guardNotEnoughMoney($balance, $amount);

        $changeAmount = FloatUtils::diff($balance->total(), $amount);

        // Exact change
        if (FloatUtils::isZero($changeAmount)) {
            $balance->empty();
            $this->repository->save($balance);

            return Coins::empty();
        }

        $changeBox = $this->changeBoxGetter->__invoke();

        $availableCoins = Coins::merge($balance->coins(), $changeBox->coins());

        try {
            // Coins to return
            $change = $availableCoins->getCoinsToSumAmount($changeAmount);
        } catch (NotEnoughCoins $e) {
            throw new NotEnoughChange();
        }

        // Remaining Coins after calculating the change
        $changeBoxWithoutChangeCoins = Coins::createFromCoinsWithoutThoseCoins($availableCoins, $change);

        $this->changeBoxSetter->__invoke($changeBoxWithoutChangeCoins);

        $balance->empty();
        $this->repository->save($balance);

        return $change;
    }

    private function guardNotEnoughMoney(Balance $balance, float $cost): void
    {
        if (!$balance->isEnough($cost)) {
            throw new NotEnoughMoney();
        }
    }
}