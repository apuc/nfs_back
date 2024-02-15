<?php

declare(strict_types=1);

namespace App\DTO\Builder;

use App\DTO\Request\PartnerTerminalCreateDTO;

class PartnerTerminalCreateDTOBuilder
{
    public static function build(array $requestData): PartnerTerminalCreateDTO
    {
        $transferredAt = null;
        if (!empty($requestData['transferred_at'])) {
            $transferredAt = new \DateTime($requestData['transferred_at']);
        }

        $returnedAt = null;
        if (!empty($requestData['returned_at'])) {
            $returnedAt = new \DateTime($requestData['returned_at']);
        }

        return (new PartnerTerminalCreateDTO())
            ->setPartnerId($requestData['partner_id'] ?? null)
            ->setTerminalId($requestData['terminal_id'] ?? null)
            ->setPackageId($requestData['package_id'] ?? null)
            ->setTransferredAt($transferredAt)
            ->setReturnedAt($returnedAt)
            ->setCost($requestData['cost'] ?? null);
    }
}
