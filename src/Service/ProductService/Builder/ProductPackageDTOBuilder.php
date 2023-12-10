<?php

declare(strict_types=1);

namespace App\Service\ProductService\Builder;

use App\Entity\ProductPackage;
use App\Service\ProductService\DTO\ProductPackageDTO;
use DateTimeImmutable;

class ProductPackageDTOBuilder
{
    public static function build(?ProductPackage $package = null): ?ProductPackageDTO
    {
        if (null === $package) {
            return null;
        }

        return (new ProductPackageDTO())
            ->setId($package->getId())
            ->setTitle($package->getTitle())
            ->setAmount($package->getAmount())
            ->setType($package->getType())
            ->setFinishedAt(DateTimeImmutable::createFromMutable($package->getFinishedAt()))
            ->setCreatedAt(DateTimeImmutable::createFromMutable($package->getCreatedAt()))
            ->setUpdatedAt(DateTimeImmutable::createFromMutable($package->getUpdatedAt()));
    }
}