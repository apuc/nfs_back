<?php

declare(strict_types=1);

namespace App\Service\GeoService\Manager;

use App\Entity\City;
use App\Repository\CityRepository;
use App\Service\GeoService\Builder\CityDTOBuilder;
use App\Service\GeoService\DTO\CityDTO;

class GeoManager
{
    public function __construct(
        private CityRepository $cityRepository,
    ) {
    }

    public function findCityByTitle(string $title): ?CityDTO
    {
        return CityDTOBuilder::build(
            $this->findCityEntityByTitle($title)
        );
    }

    public function findCityEntityByTitle(string $title): ?City
    {
        return $this->cityRepository->findOneBy(['title' => trim($title)]);
    }
}
