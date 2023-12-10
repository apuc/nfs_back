<?php

declare(strict_types=1);

namespace App\Service\ProductService\Component;

use App\DTO\Request\ProductCreateDTO;
use App\DTO\Request\ProductEditDTO;
use App\Entity\Product;
use App\Repository\ProductPackageRepository;
use App\Repository\ProductRepository;
use App\Service\PartnerService\PartnerService;
use App\Service\ProductService\Builder\ProductDTOBuilder;
use App\Service\ProductService\Constants\ProductConstants;
use App\Service\ProductService\DTO\ProductDTO;
use Psr\Log\LoggerInterface;

class ProductActionComponent
{
    public function __construct(
        private ProductRepository $productRepository,
        private PartnerService $partnerService,
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

    public function view(int $identifier): ?ProductDTO
    {
        return ProductDTOBuilder::build(
            $this->productRepository->findOneBy(['id' => $identifier])
        );
    }

    public function create(ProductCreateDTO $requestDTO): ProductDTO
    {
        $product = $this->productRepository->findProductByHash($requestDTO->getHash());

        if (null === $product) {
            $product = (new Product())
                ->setPartner($this->partnerService->findEntityById($requestDTO->getPartnerId()))
                ->setProductPackage($this->packageRepository->findOneBy(['id' => $requestDTO->getPackageId()]))
                ->setTitle($requestDTO->getTitle())
                ->setAmount($requestDTO->getAmount())
                ->setDescription($requestDTO->getDescription())
                ->setUseCount($requestDTO->getUseCount())
                ->setHash($requestDTO->getHash());

            $this->productRepository->save($product);
        }

        return ProductDTOBuilder::build($product);
    }

    public function edit(ProductEditDTO $requestDTO): ProductDTO
    {
        $product = $this->productRepository->findOneBy(['id' => $requestDTO->getId()]);

        if (null !== $product) {
            $partner = $product->getPartner();
            if (null !== $requestDTO->getPartnerId()) {
                $partner = $this->partnerService->findEntityById($requestDTO->getPartnerId());
            }

            $package = $product->getProductPackage()->getId();
            if (null !== $requestDTO->getPackageId()) {
                $package = $this->packageRepository->findOneBy(['id' => $requestDTO->getPackageId()]);
            }

            $product
                ->setPartner($partner)
                ->setProductPackage($package)
                ->setTitle($requestDTO->getTitle() ?? $product->getTitle())
                ->setAmount($requestDTO->getAmount() ?? $product->getAmount())
                ->setDescription($requestDTO->getDescription() ?? $product->getDescription())
                ->setUseCount($requestDTO->getUseCount() ?? $product->getUseCount());

            $this->productRepository->save($product);
        }

        return ProductDTOBuilder::build($product);
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
        } catch (\Throwable $exception) {
            $this->productLogger->critical(
                'Error when product remove: '.$exception->getMessage(),
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
