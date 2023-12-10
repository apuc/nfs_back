<?php

declare(strict_types=1);

namespace App\Service\TerminalService\Builder;

use App\Entity\PartnerTerminal;
use App\Service\PartnerService\Builder\PartnerDTOBuilder;
use App\Service\ProductService\Builder\ProductPackageDTOBuilder;
use App\Service\TerminalService\DTO\PartnerTerminalDTO;

class PartnerTerminalDTOBuilder
{
    public static function build(PartnerTerminal $partnerTerminal = null): ?PartnerTerminalDTO
    {
        if (null === $partnerTerminal) {
            return null;
        }

        return (new PartnerTerminalDTO())
            ->setId($partnerTerminal->getId())
            ->setPartner(PartnerDTOBuilder::build($partnerTerminal->getPartner()))
            ->setTerminal(TerminalDTOBuilder::build($partnerTerminal->getTerminal()))
            ->setProductPackage(ProductPackageDTOBuilder::build($partnerTerminal->getProductPackage()))
            ->setTransferredAt(\DateTimeImmutable::createFromMutable($partnerTerminal->getTransferredAt()))
            ->setReturnedAt(\DateTimeImmutable::createFromMutable($partnerTerminal->getReturnedAt()))
            ->setCost($partnerTerminal->getCost())
            ->setCreatedAt(\DateTimeImmutable::createFromMutable($partnerTerminal->getCreatedAt()))
            ->setUpdatedAt(\DateTimeImmutable::createFromMutable($partnerTerminal->getUpdatedAt()));
    }
}
