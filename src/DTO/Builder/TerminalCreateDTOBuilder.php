<?php

declare(strict_types=1);

namespace App\DTO\Builder;

use App\DTO\Request\TerminalCreateDTO;

class TerminalCreateDTOBuilder
{
    public static function build(array $requestData): TerminalCreateDTO
    {
        return (new TerminalCreateDTO())
            ->setTitle($requestData['title'] ?? null)
            ->setSerial($requestData['serial'] ?? null)
            ->setModelName($requestData['model_name'] ?? null)
            ->setSimCardNumber($requestData['sim_card_number'] ?? null)
            ->setMcamCardNumber($requestData['mcam_card_number'] ?? null)
            ->setHash(md5(json_encode($requestData)));
    }
}
