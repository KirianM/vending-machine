<?php

declare(strict_types=1);

namespace VendorMachine\Machine\Balance\Domain;

use VendorMachine\Machine\Change\Domain\MachineChangeGetter;
use VendorMachine\Machine\Change\Domain\MachineChangeSetter;
use VendorMachine\Machine\Products\Domain\NotEnoughChange;
use VendorMachine\Shared\Domain\Coins;
use VendorMachine\Shared\Domain\FloatUtils;

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

        if (!$balance->isEnough($amount)) {
            throw new NotEnoughMoney();
        }

        $amountsDiff = FloatUtils::diff($balance->total(), $amount);

        $changeBox = $this->changeBoxGetter->__invoke();
        $availableCoins = Coins::merge($balance->coins(), $changeBox->coins());

        if (!FloatUtils::isZero($amountsDiff)) {
            // Collection of coins to return
            $change = Coins::extractCoinsForAmount($availableCoins, $amountsDiff);

            if (!FloatUtils::areEqual($change->total(), $amountsDiff)) {
                throw new NotEnoughChange();
            }

            // Final Collection of coins after return the change
            $changeWithoutChangeCoins = Coins::removeCoinsFromCollection($availableCoins, $change);

            $this->changeBoxSetter->__invoke($changeWithoutChangeCoins);
        } else {
            // No change is needed
            $change = Coins::empty();
            $this->changeBoxSetter->__invoke($availableCoins);
        }

        $balance->empty();
        
        $this->repository->save($balance);

        return $change;
    }
}