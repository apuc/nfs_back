<?php

declare(strict_types=1);

namespace API\DTO\Builder;

use API\DTO\Request\PartnerRequestDTO;
use Symfony\Component\HttpFoundation\Request;

class PartnerRequestDTOBuilder
{
    public static function build(Request $request): PartnerRequestDTO
    {
        return (new PartnerRequestDTO())
            ->setId($request->get('id'))
            ->setName($request->get('name'))
            ->setOccupation($request->get('occupation'))
            ->setInn($request->get('inn'))
            ->setKpp(trim($request->get('kpp')))
            ->setOgrn(trim($request->get('ogrn')))
            ->setAddress(trim($request->get('address')))
            ->setBank(trim($request->get('bank')))
            ->setBik(trim($request->get('bik')))
            ->setAccountNumber(trim($request->get('account_number')))
            ->setCorrAccountNumber(trim($request->get('corr_account_number')))
            ->setPhoneNumber(trim($request->get('phone_number')))
            ->setEmail(trim($request->get('email')));
    }
}
