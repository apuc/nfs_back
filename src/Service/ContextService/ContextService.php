<?php

declare(strict_types=1);

namespace App\Service\ContextService;

use App\Base\Constants\MenuConstants;
use App\Base\Constants\PageTitleConstants;

class ContextService
{
    public string $activeMenuItemAlias = MenuConstants::INDEX_MENU_ITEM;

    public function setActiveMenuItemAlias(string $alias = null): self
    {
        $this->activeMenuItemAlias = $alias ?? MenuConstants::INDEX_MENU_ITEM;

        return $this;
    }

    public function getMenuItemActiveFlag(string $alias): ?string
    {
        return $alias === $this->activeMenuItemAlias ? 'active' : null;
    }

    public function getMainMenuItemOpenedFlag(string $alias): ?string
    {
        $mainMenuItem = MenuConstants::MENU_LEVELS[$this->activeMenuItemAlias] ?? null;

        return (null !== $mainMenuItem && $alias === $mainMenuItem) ? 'open' : null;
    }

    public function getPageTitle(): string
    {
        $titleParts = ['НФС'];

        $currentPageTitle = PageTitleConstants::PAGE_TITLES[$this->activeMenuItemAlias] ?? null;
        if (null !== $currentPageTitle) {
            $titleParts[] = $currentPageTitle;
        }

        return implode(' - ', $titleParts);
    }
}
