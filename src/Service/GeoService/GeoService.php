<?php

declare(strict_types=1);

namespace App\Service\GeoService;

use App\Entity\City;
use App\Service\GeoService\DTO\CityDTO;
use App\Service\GeoService\Manager\GeoManager;

class GeoService
{
    public function __construct(
        private GeoManager $manager
    ) {
    }

    public function findDTOByTitle(string $title = null): ?CityDTO
    {
        if (null === $title) {
            return null;
        }

        return $this->manager->findCityByTitle($title);
    }

    public function findEntityByTitle(string $title = null): ?City
    {
        return $this->manager->findCityEntityByTitle($title);
    }
}
