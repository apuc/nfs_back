<?php

declare(strict_types=1);

namespace App\Service\PartnerService;

use App\Entity\Partner;
use App\Repository\PartnerRepository;

class PartnerService
{
    public function __construct(
        private PartnerRepository $repository,
    ) {
    }

    public function findEntityById(int $identifier): ?Partner
    {
        return $this->repository->findOneBy(['id' => $identifier]);
    }
}
