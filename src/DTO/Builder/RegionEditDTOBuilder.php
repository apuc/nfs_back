<?php

declare(strict_types=1);

namespace App\DTO\Builder;

use App\DTO\Request\RegionEditDTO;

class RegionEditDTOBuilder
{
    public static function build(int $identifier, array $requestData)
    {
        return (new RegionEditDTO())
            ->setId($identifier)
            ->setTitle($requestData['title'] ?? null);
    }
}
