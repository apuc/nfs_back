<?php

declare(strict_types=1);

namespace App\DTO\Builder;

use App\DTO\Request\ProductCreateDTO;

class ProductCreateDTOBuilder
{
    public static function build(array $requestData): ProductCreateDTO
    {
        return (new ProductCreateDTO())
            ->setPartnerId($requestData['partner_id'] ?? null)
            //->setPackageId($requestData['package_id'] ?? null)
            ->setTitle($requestData['title'] ?? null)
            ->setAmount($requestData['amount'] ?? null)
            ->setDescription($requestData['description'] ?? null)
            ->setUseCount($requestData['use_count'] ?? null)
            ->setHash(md5(json_encode($requestData)));
    }
}
