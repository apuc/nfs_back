<?php

declare(strict_types=1);

namespace App\Service\ProductService\Component;

use App\DTO\Request\ProductPackageCreateDTO;
use App\DTO\Request\ProductPackageEditDTO;
use App\Entity\ProductPackage;
use App\Repository\ProductPackageRepository;
use App\Service\ProductService\Builder\ProductPackageDTOBuilder;
use App\Service\ProductService\Constants\ProductConstants;
use App\Service\ProductService\DTO\ProductPackageDTO;
use Psr\Log\LoggerInterface;

class ProductPackageActionComponent
{
    public function __construct(
        private ProductPackageRepository $packageRepository,
        private LoggerInterface $productLogger,
    ) {
    }

    /**
     * @return ProductPackageDTO[]
     */
    public function getList(): array
    {
        $result = [];
        foreach ($this->packageRepository->findAllNotRemoved() as $package) {
            $result[] = ProductPackageDTOBuilder::build($package);
        }

        return $result;
    }

    public function view(int $identifier): ?ProductPackageDTO
    {
        return ProductPackageDTOBuilder::build(
            $this->packageRepository->findOneBy(['id' => $identifier])
        );
    }

    public function create(ProductPackageCreateDTO $requestDTO): ProductPackageDTO
    {
        $productPackage = $this->packageRepository->findProductPackageByHash($requestDTO->getHash());

        if (null === $productPackage) {
            $productPackage = (new ProductPackage())
                ->setTitle($requestDTO->getTitle())
                ->setAmount($requestDTO->getAmount())
                ->setFinishedAt($requestDTO->getFinishedAt())
                ->setType($requestDTO->getType())
                ->setHash($requestDTO->getHash());

            $this->packageRepository->save($productPackage);
        }

        return ProductPackageDTOBuilder::build($productPackage);
    }

    public function edit(ProductPackageEditDTO $requestDTO): ProductPackageDTO
    {
        $productPackage = $this->packageRepository->findOneBy(['id' => $requestDTO->getId()]);

        if (null !== $productPackage) {
            $productPackage
                ->setTitle($requestDTO->getTitle() ?? $productPackage->getTitle())
                ->setAmount($requestDTO->getAmount() ?? $productPackage->getAmount())
                ->setFinishedAt($requestDTO->getFinishedAt() ?? $productPackage->getFinishedAt())
                ->setType($requestDTO->getType() ?? $productPackage->getType());

            $this->packageRepository->save($productPackage);
        }

        return ProductPackageDTOBuilder::build($productPackage);
    }

    public function deleteItem(int $identifier): bool
    {
        try {
            $productPackage = $this->packageRepository->findOneBy(['id' => $identifier]);
            if (null !== $productPackage) {
                $productPackage->setStatus(ProductConstants::STATUS_REMOVED);

                $this->packageRepository->save($productPackage);
            }

            return true;
        } catch (\Throwable $exception) {
            $this->productLogger->critical(
                'Error when product package remove: '.$exception->getMessage(),
                [
                    'identifier' => $identifier,
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                ]
            );

            return false;
        }
    }
}
