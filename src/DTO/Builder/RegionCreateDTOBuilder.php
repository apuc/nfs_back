<?php

declare(strict_types=1);

namespace App\DTO\Builder;

use App\DTO\Request\RegionCreateDTO;

class RegionCreateDTOBuilder
{
    public static function build(array $requestData): RegionCreateDTO
    {
        return (new RegionCreateDTO())
            ->setTitle($requestData['title'] ?? null);
    }
}
