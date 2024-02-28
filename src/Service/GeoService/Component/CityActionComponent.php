<?php

namespace App\Service\GeoService\Component;

use App\DTO\Request\CityCreateDTO;
use App\DTO\Request\CityEditDTO;
use App\Entity\City;
use App\Repository\CityRepository;
use App\Repository\RegionRepository;
use App\Service\GeoService\Builder\CityDTOBuilder;
use App\Service\GeoService\DTO\CityDTO;
use Psr\Log\LoggerInterface;

class CityActionComponent
{
    public function __construct(
        private CityRepository $repository,
        private RegionRepository $regionRepository,
        private LoggerInterface $orderLogger,
    ) {
    }

    public function createNew(CityCreateDTO $createDTO): CityDTO
    {
        $city = (new City())
            ->setTitle($createDTO->getTitle())
            ->setRegion($this->regionRepository->findById($createDTO->getRegionId()));

        $this->repository->save($city);

        return CityDTOBuilder::build($city);
    }

    public function getList(): array
    {
        $result = [];
        foreach ($this->repository->findAll() as $order) {
            $result[] = CityDTOBuilder::build($order);
        }

        return $result;
    }

    public function view(int $identifier): ?CityDTO
    {
        return CityDTOBuilder::build(
            $this->repository->findOneBy(['id' => $identifier])
        );
    }

    public function edit(CityEditDTO $editDTO): CityDTO
    {
        $city = $this->repository->findById($editDTO->getId());
        $region = $this->regionRepository->findById($editDTO->getRegionId());

        if (null !== $city) {
            $city->setTitle($editDTO->getTitle() ?? $city->getTitle())
                ->setRegion($this->regionRepository->findById($editDTO->getRegionId()) ?? $region);

            $this->repository->save($city);
        }

        return CityDTOBuilder::build($city);
    }
}
