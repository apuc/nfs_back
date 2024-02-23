<?php

declare(strict_types=1);

namespace App\Service\GeoService\Builder;

use App\Entity\Region;
use App\Service\GeoService\DTO\RegionDTO;

class RegionDTOBuilder
{
    public static function build(Region $region = null): ?RegionDTO
    {
        if (null === $region) {
            return $region;
        }

        return (new RegionDTO())
            ->setId($region->getId())
            ->setTitle($region->getTitle())
            ->setCreatedAt(\DateTimeImmutable::createFromMutable($region->getCreatedAt()))
            ->setUpdatedAt(\DateTimeImmutable::createFromMutable($region->getUpdatedAt()));
    }
}
