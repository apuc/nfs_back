<?php

declare(strict_types=1);

namespace App\Base\Helper;

class RuntimeHelper
{
    public static function isConsoleLaunched(): bool
    {
        return 'cli' === PHP_SAPI;
    }
}
