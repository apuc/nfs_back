<?php

declare(strict_types=1);

namespace App\Base\Helper;

class DateTimeHelper
{
    public static function viewInFormat(?\DateTimeInterface $dateTime, string $format = 'd.m.Y'): string
    {
        return $dateTime?->format($format) ?? 'null';
    }
}
