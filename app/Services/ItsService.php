<?php

namespace App\Services;

class ItsService
{
    public const LOWERTHAN_60000 = 0;

    public const BETWEEN_60001_AND_150000 = 10;

    public const BETWEEN_150001_AND_250000 = 15;

    public const BETWEEN_250001_AND_500000 = 19;

    public const HIGHERTHAN_500000 = 30;

    public static function getIts(int $salaire): int
    {
        if ($salaire <= 60000) {
            return self::LOWERTHAN_60000;
        } elseif ($salaire <= 150000) {
            return self::BETWEEN_60001_AND_150000;
        } elseif ($salaire <= 250000) {
            return self::BETWEEN_150001_AND_250000;
        } elseif ($salaire <= 500000) {
            return self::BETWEEN_250001_AND_500000;
        } else {
            return self::HIGHERTHAN_500000;
        }

    }
}
