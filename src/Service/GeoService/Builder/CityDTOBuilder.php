<?php

declare(strict_types=1);

namespace App\Service\GeoService\Builder;

use App\Entity\City;
use App\Service\GeoService\DTO\CityDTO;
use App\Service\GeoService\DTO\RegionDTO;

class CityDTOBuilder
{
    public static function build(City $city = null): ?CityDTO
    {
        if (null === $city) {
            return $city;
        }

        return (new CityDTO())
            ->setId($city->getId())
            ->setTitle($city->getTitle())
            ->setRegion(
                (new RegionDTO())
                    ->setId($city->getRegion()->getId())
                    ->setTitle($city->getRegion()->getTitle())
                    ->setCreatedAt(\DateTimeImmutable::createFromMutable($city->getRegion()->getCreatedAt()))
                    ->setUpdatedAt(\DateTimeImmutable::createFromMutable($city->getRegion()->getUpdatedAt()))
            )
            ->setCreatedAt(\DateTimeImmutable::createFromMutable($city->getCreatedAt()))
            ->setUpdatedAt(\DateTimeImmutable::createFromMutable($city->getUpdatedAt()));
    }
}
