<?php

declare(strict_types=1);

namespace App\DTO\Builder;

use App\DTO\Request\CityCreateDTO;

class CityCreateDTOBuilder
{
    public static function build(array $requestData): CityCreateDTO
    {
        return (new CityCreateDTO())
            ->setTitle($requestData['title'] ?? null)
            ->setRegionId($requestData['region_id'] ?? null);
    }
}
