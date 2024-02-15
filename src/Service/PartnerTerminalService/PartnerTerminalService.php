<?php

declare(strict_types=1);

namespace App\Service\PartnerTerminalService;

use App\Repository\PartnerTerminalRepository;

class PartnerTerminalService
{

    public function __construct(
        private PartnerTerminalRepository $partnerTerminal,
    ) {
    }

}