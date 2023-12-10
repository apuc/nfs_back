<?php

declare(strict_types=1);

namespace App\Service\ProductService;

use App\Entity\ProductPackage;
use App\Repository\ProductPackageRepository;
use App\Repository\ProductRepository;

class ProductService
{
    public function __construct(
        private ProductPackageRepository $packageRepository,
        private ProductRepository $productRepository,
    ) {
    }

    public function findProductPackageById(int $identifier): ?ProductPackage
    {
        return $this->packageRepository->findOneBy(['id' => $identifier]);
    }

    public function findNotRemoveProductsByPackageBy(int $packageId): array
    {
        return $this->productRepository->findNotRemovedByPackageId($packageId);
    }
}
