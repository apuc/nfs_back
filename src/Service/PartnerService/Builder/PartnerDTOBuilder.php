<?php

declare(strict_types=1);

namespace App\Service\PartnerService\Builder;

use App\Entity\Partner;
use App\Service\GeoService\Builder\CityDTOBuilder;
use App\Service\PartnerService\DTO\PartnerContactsDTO;
use App\Service\PartnerService\DTO\PartnerDetailsDTO;
use App\Service\PartnerService\DTO\PartnerDTO;

class PartnerDTOBuilder
{
    public static function build(Partner $partner = null): ?PartnerDTO
    {
        if (null === $partner) {
            return null;
        }

        return (new PartnerDTO())
            ->setId($partner->getId())
            ->setTitle($partner->getTitle())
            ->setDetails(
                (new PartnerDetailsDTO())
                    ->setInn((int) $partner->getDetailsByKey('inn'))
                    ->setKpp((int) $partner->getDetailsByKey('kpp'))
                    ->setOgrn((int) $partner->getDetailsByKey('ogrn'))
                    ->setAddress($partner->getDetailsByKey('address'))
                    ->setBank($partner->getDetailsByKey('bank'))
                    ->setBik((int) $partner->getDetailsByKey('bik'))
                    ->setAccountNumber($partner->getDetailsByKey('account_number'))
                    ->setCorrAccountNumber($partner->getDetailsByKey('corr_account_number'))
            )
            ->setContacts(
                (new PartnerContactsDTO())
                    ->setPhoneNumber($partner->getContactsByKey('phone_number'))
                    ->setEmail($partner->getContactsByKey('email'))
            )
            ->setOccupation($partner->getOccupation())
            ->setStatus($partner->getStatus())
            ->setCity(CityDTOBuilder::build($partner->getCity()))
            ->setCreatedAt(\DateTimeImmutable::createFromMutable($partner->getCreatedAt()))
            ->setUpdatedAt(\DateTimeImmutable::createFromMutable($partner->getUpdatedAt()));
    }
}
