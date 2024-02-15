<?php

declare(strict_types=1);

namespace App\Service\PartnerTerminalService\Builder;

use App\Entity\PartnerTerminal;
use App\Service\PartnerService\Builder\PartnerDTOBuilder;
use App\Service\PartnerTerminalService\PartnerTerminalDTO;
use App\Service\ProductService\Builder\ProductPackageDTOBuilder;
use App\Service\TerminalService\Builder\TerminalDTOBuilder;

class PartnerTerminalDTOBuilder
{
    public static function build(PartnerTerminal $partnerTerminal)
    {

        return (new PartnerTerminalDTO())
            ->setId($partnerTerminal->getId())
            ->setPartner(PartnerDTOBuilder::build($partnerTerminal->getPartner()))
            ->setTerminal(TerminalDTOBuilder::build($partnerTerminal->getTerminal()))
            ->setProductPackage(ProductPackageDTOBuilder::build($partnerTerminal->getProductPackage()))
            ->setTransferredAt($partnerTerminal->getTransferredAt())
            ->setReturnedAt($partnerTerminal->getReturnedAt())
            ->setCost($partnerTerminal->getCost());
    }
}
