<?php

declare(strict_types=1);

namespace App\DTO\Builder;

use App\DTO\Request\TerminalEditDTO;

class TerminalEditDTOBuilder
{
    public static function build(int $identifier, array $requestData): TerminalEditDTO
    {
        return (new TerminalEditDTO())
            ->setId($identifier)
            ->setTitle($requestData['title'] ?? null)
            ->setSerial($requestData['serial'] ?? null)
            ->setModelName($requestData['model_name'] ?? null)
            ->setSimCardNumber($requestData['sim_card_number'] ?? null)
            ->setMcamCardNumber($requestData['mcam_card_number'] ?? null);
    }
}
