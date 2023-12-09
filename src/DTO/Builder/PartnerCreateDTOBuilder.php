<?php

declare(strict_types=1);

namespace App\DTO\Builder;

use App\DTO\Request\PartnerCreateDTO;

class PartnerCreateDTOBuilder
{
    public static function build(array $requestData): PartnerCreateDTO
    {
        return (new PartnerCreateDTO())
            ->setTitle($requestData['title'] ?? null)
            ->setOccupation($requestData['occupation'] ?? null)
            ->setInn($requestData['inn'] ?? null)
            ->setKpp($requestData['kpp'] ?? null)
            ->setOgrn($requestData['ogrn'] ?? null)
            ->setAddress($requestData['address'] ?? null)
            ->setBank($requestData['bank'] ?? null)
            ->setBik($requestData['bik'] ?? null)
            ->setAccountNumber($requestData['account_number'] ?? null)
            ->setCorrAccountNumber($requestData['corr_account_number'] ?? null)
            ->setPhoneNumber($requestData['phone_number'] ?? null)
            ->setEmail($requestData['email'] ?? null)
            ->setCity($requestData['city'] ?? null)
            ->setHash(md5(json_encode($requestData)));
    }
}
