<?php

declare(strict_types=1);

namespace App\Service\ProductService\Constants;

class ProductConstants
{
    /**
     * Полный пакет услуг, доступны все услуги
     */
    public const FULL = 1;

    /**
     * Частичный пакет услуг, доступна только часть услуг
     */
    public const PARTIAL = 2;

    public const STATUS_ACTIVE = 1;
    public const STATUS_REMOVED = 99;
}