<?php

declare(strict_types=1);

namespace App\Service\PartnerService\Builder;

use App\Entity\Partner;
use App\Service\PartnerService\PartnerContactsDTO;
use App\Service\PartnerService\PartnerDetailsDTO;
use App\Service\PartnerService\PartnerDTO;

class PartnerDTOBuilder
{
    public static function build(Partner $partner): PartnerDTO
    {
        return (new PartnerDTO())
            ->setId($partner->getId())
            ->setName($partner->getName())
            ->setDetails(
                new PartnerDetailsDTO()
            )
            ->setContacts(
                new PartnerContactsDTO()
            )
            ->setOccupation($partner->getOccupation())
            ->setCreatedAt(\DateTimeImmutable::createFromMutable($partner->getCreatedAt()))
            ->setUpdatedAt(\DateTimeImmutable::createFromMutable($partner->getUpdatedAt()));
    }
}
