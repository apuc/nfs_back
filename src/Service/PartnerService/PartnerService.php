<?php

declare(strict_types=1);

namespace App\Service\PartnerService;

use App\Service\PartnerService\Manager\PartnerManager;

class PartnerService
{
    public function __construct(
        private PartnerManager $manager
    ) {
    }

    public function getList(): array
    {
        return [];
    }

    public function createNew(): void
    {
    }

    public function edit(): void
    {
    }

    public function delete(): void
    {
    }
}
