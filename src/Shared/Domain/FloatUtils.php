<?php

declare(strict_types=1);

namespace VendorMachine\Shared\Domain;

final class FloatUtils
{
    public static function isBiggerThan(float $num1, float $num2): bool
    {
        return (($num1 - $num2) > PHP_FLOAT_EPSILON);
    }

    public static function areEqual(float $num1, float $num2): bool
    {
        return (abs($num1 - $num2) < PHP_FLOAT_EPSILON);
    }

    public static function diff(float $num1, float $num2): float
    {
        return $num1 - $num2;
    }

    public static function isZero(float $num): bool
    {
        return ($num < PHP_FLOAT_EPSILON);
    }
}