<?php

declare(strict_types=1);

namespace App\DTO\Builder;

use App\DTO\Request\CityEditDTO;

class CityEditDTOBuilder
{
    public static function build(int $identifier, array $requestData): CityEditDTO
    {
        return (new CityEditDTO())
            ->setId($identifier)
            ->setTitle($requestData['title'] ?? null)
            ->setRegionId($requestData['region_id'] ?? null);
    }
}
