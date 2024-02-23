<?php

namespace App\Service\GeoService\Component;

use App\DTO\Request\RegionCreateDTO;
use App\DTO\Request\RegionEditDTO;
use App\Entity\Region;
use App\Repository\RegionRepository;
use App\Service\GeoService\Builder\RegionDTOBuilder;
use App\Service\GeoService\DTO\RegionDTO;
use Psr\Log\LoggerInterface;

class RegionActionComponent
{
    public function __construct(
        private RegionRepository $repository,
        private LoggerInterface $orderLogger,
    ) {
    }

    public function createNew(RegionCreateDTO $createDTO): RegionDTO
    {
        $order = (new Region())
            ->setTitle($createDTO->getTitle());

        $this->repository->save($order);

        return RegionDTOBuilder::build($order);
    }

    public function getList(): array
    {
        $result = [];
        foreach ($this->repository->findAll() as $order) {
            $result[] = RegionDTOBuilder::build($order);
        }

        return $result;
    }

    public function view(int $identifier): ?RegionDTO
    {
        return RegionDTOBuilder::build(
            $this->repository->findOneBy(['id' => $identifier])
        );
    }

    public function edit(RegionEditDTO $editDTO): RegionDTO
    {
        $region = $this->repository->findById($editDTO->getId());

        if (null !== $region) {
            $region->setTitle($editDTO->getTitle() ?? $region->getTitle());

            $this->repository->save($region);
        }

        return RegionDTOBuilder::build($region);
    }

    public function deleteItem(int $identifier): bool
    {
        try {
            $partner = $this->repository->findOneBy(['id' => $identifier]);
            if (null !== $partner) {
                $partner->setStatus(OrderConstants::STATUS_REMOVED);

                $this->repository->save($partner);
            }

            return true;
        } catch (\Throwable $exception) {
            $this->orderLogger->critical(
                'Error when partner remove: '.$exception->getMessage(),
                [
                    'identifier' => $identifier,
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                ]
            );

            return false;
        }
    }
}
