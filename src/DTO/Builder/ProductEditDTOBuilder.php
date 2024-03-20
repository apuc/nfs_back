<?php

declare(strict_types=1);

namespace App\DTO\Builder;

use App\DTO\Request\ProductEditDTO;

class ProductEditDTOBuilder
{
    public static function build(int $identifier, array $requestData): ProductEditDTO
    {
        return (new ProductEditDTO())
            ->setId($identifier)
            ->setPartnerId($requestData['partner_id'] ?? null)
            ->setTitle($requestData['title'] ?? null)
            ->setAmount($requestData['amount'] ?? null)
            ->setDescription($requestData['description'] ?? null)
            ->setUseCount($requestData['use_count'] ?? null)
            ->setHash(md5(json_encode($requestData)));
    }
}
