<?php

declare(strict_types=1);

namespace App\Service\PartnerService\Manager;

use App\Service\AuthService\Repository\PartnerRepository;

class PartnerManager
{
    public function __construct(
        private PartnerRepository $repository
    ) {
    }
}
