<?php

declare(strict_types=1);

namespace App\Base\Constants;

class MenuConstants
{
    public const INDEX_MENU_ITEM = 'index';

    public const CATALOG_MENU_ITEM = 'catalog';
    public const CATALOG_MENU_PARTNERS_ITEM = 'partners_list';

    public const MENU_LEVELS = [
        self::CATALOG_MENU_PARTNERS_ITEM => self::CATALOG_MENU_ITEM,
    ];
}
