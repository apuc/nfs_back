<?php

declare(strict_types=1);

namespace App\DTO\Builder;

use App\DTO\Request\ProductPackageProductCreateDTO;

class ProductPackageProductCreateDTOBuilder
{
    public static function build(array $requestData): ProductPackageProductCreateDTO
    {
        return (new ProductPackageProductCreateDTO())
            ->setProductId($requestData['product_id'] ?? null)
            ->setProductPackageId($requestData['product_package_id'] ?? null);
    }
}
