<?php

declare(strict_types=1);

namespace App\Service\ProductService;

use App\Repository\ProductPackageRepository;
use App\Repository\ProductRepository;
use App\Service\ProductService\Builder\ProductDTOBuilder;
use App\Service\ProductService\Constants\ProductConstants;
use App\Service\ProductService\DTO\ProductDTO;
use Psr\Log\LoggerInterface;
use Throwable;

class ProductService
{
    public function __construct(
        private ProductRepository $productRepository,
        private ProductPackageRepository $packageRepository,
        private LoggerInterface $productLogger,
    ) {
    }

    /**
     * @return ProductDTO[]
     */
    public function getList(): array
    {
        $result = [];
        foreach ($this->productRepository->findAllNotRemoved() as $product) {
            $result[] = ProductDTOBuilder::build($product);
        }

        return $result;
    }

    public function view(int $identifier): ProductDTO
    {
        return ProductDTOBuilder::build(
            $this->productRepository->findOneBy(['id' => $identifier])
        );
    }

    public function deleteItem(int $identifier): bool
    {
        try {
            $product = $this->productRepository->findOneBy(['id' => $identifier]);
            if (null !== $product) {
                $product->setStatus(ProductConstants::STATUS_REMOVED);

                $this->productRepository->save($product);
            }

            return true;
        } catch (Throwable $exception) {
            $this->productLogger->critical(
                'Error when product remove: ' . $exception->getMessage(),
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