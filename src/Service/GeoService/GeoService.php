<?php

declare(strict_types=1);

namespace App\Service\GeoService;

use App\Entity\City;
use App\Repository\CityRepository;
use App\Service\GeoService\Builder\CityDTOBuilder;
use App\Service\GeoService\DTO\CityDTO;

class GeoService
{
    public function __construct(
        private CityRepository $cityRepository,
    ) {
    }

    public function findDTOByTitle(string $title): ?CityDTO
    {
        return CityDTOBuilder::build(
            $this->findEntityByTitle($title)
        );
    }

    public function findEntityByTitle(string $title): ?City
    {
        return $this->cityRepository->findOneBy(['title' => trim($title)]);
    }
}
