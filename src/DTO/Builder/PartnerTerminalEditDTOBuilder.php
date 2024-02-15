<?php

declare(strict_types=1);

namespace App\DTO\Builder;

use App\DTO\Request\PartnerTerminalEditDTO;

class PartnerTerminalEditDTOBuilder
{
    public static function build(int $identifier, array $requestData): PartnerTerminalEditDTO
    {
        $transferredAt = null;
        if (!empty($requestData['transferred_at'])) {
            $transferredAt = new \DateTime($requestData['transferred_at']);
        }

        $returnedAt = null;
        if (!empty($requestData['returned_at'])) {
            $returnedAt = new \DateTime($requestData['returned_at']);
        }

        return (new PartnerTerminalEditDTO())
            ->setId($identifier)
            ->setPartnerId($requestData['partner_id'] ?? null)
            ->setTerminalId($requestData['terminal_id'] ?? null)
            ->setPackageId($requestData['package_id'] ?? null)
            ->setTransferredAt($transferredAt)
            ->setReturnedAt($returnedAt)
            ->setCost($requestData['cost'] ?? null);
    }
}
