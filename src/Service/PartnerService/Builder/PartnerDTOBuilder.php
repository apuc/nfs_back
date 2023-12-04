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
                (new PartnerDetailsDTO())
                ->setInn($partner->getDetailsByKey('inn'))
                ->setKpp($partner->getDetailsByKey('kpp'))
                ->setOgrn($partner->getDetailsByKey('ogrn'))
                ->setAddress($partner->getDetailsByKey('address'))
                ->setBank($partner->getDetailsByKey('bank'))
                ->setBik($partner->getDetailsByKey('bik'))
                ->setAccountNumber($partner->getDetailsByKey('account'))
                ->setCorrAccountNumber($partner->getDetailsByKey('corr_account'))
            )
            ->setContacts(
                (new PartnerContactsDTO())
                    ->setPhoneNumber($partner->getContactsByKey('phone_number'))
                    ->setEmail($partner->getContactsByKey('email'))
            )
            ->setOccupation($partner->getOccupation())
            ->setCreatedAt(\DateTimeImmutable::createFromMutable($partner->getCreatedAt()))
            ->setUpdatedAt(\DateTimeImmutable::createFromMutable($partner->getUpdatedAt()));
    }
}
