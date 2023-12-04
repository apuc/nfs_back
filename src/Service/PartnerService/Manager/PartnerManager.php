<?php

declare(strict_types=1);

namespace App\Service\PartnerService\Manager;

use App\Repository\PartnerRepository;
use App\Service\PartnerService\Builder\PartnerDTOBuilder;
use App\Service\PartnerService\PartnerDTO;

class PartnerManager
{
    public function __construct(
        private PartnerRepository $repository
    ) {
    }

    /**
     * @return PartnerDTO[]
     */
    public function getList(): array
    {
        $result = [];
        foreach ($this->repository->findAll() as $partner) {
            $result[] = PartnerDTOBuilder::build($partner);
        }

        return $result;
    }
}
