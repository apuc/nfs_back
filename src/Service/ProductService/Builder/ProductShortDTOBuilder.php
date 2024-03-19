<?php

declare(strict_types=1);

namespace App\Service\ProductService\Builder;

use App\Entity\Product;
use App\Service\PartnerService\Builder\PartnerDTOBuilder;
use App\Service\ProductService\DTO\ProductDTO;
use App\Service\ProductService\DTO\ProductShortDTO;

class ProductShortDTOBuilder
{
    public static function build(Product $product = null): ?ProductShortDTO
    {
        if (null === $product) {
            return null;
        }

        return (new ProductShortDTO())
            ->setId($product->getId())
            ->setTitle($product->getTitle())
            ->setDescription($product->getDescription())
            ->setAmount($product->getAmount())
            ->setUseCount($product->getUseCount())
            ->setStatus($product->getStatus())
            ->setHash($product->getHash())
            ->setCreatedAt(\DateTimeImmutable::createFromMutable($product->getCreatedAt()))
            ->setUpdatedAt(\DateTimeImmutable::createFromMutable($product->getUpdatedAt()));
    }
}
