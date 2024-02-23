<?php

declare(strict_types=1);

namespace App\Service\CertificateService\Component;

use App\DTO\Request\CertificateCreateDTO;
use App\DTO\Request\CertificateEditDTO;
use App\Entity\Certificate;
use App\Repository\CertificateRepository;
use App\Repository\ProductPackageRepository;
use App\Service\CertificateService\Builder\CertificateDTOBuilder;
use App\Service\CertificateService\CertificateService;
use App\Service\CertificateService\Constants\CertificateConstants;
use App\Service\CertificateService\DTO\CertificateDTO;
use App\Service\OrderService\OrderService;
use Psr\Log\LoggerInterface;

class CertificateActionComponent
{
    public function __construct(
        private CertificateRepository $repository,
        private CertificateService $certificateService,
        private ProductPackageRepository $packageRepository,
        private OrderService $orderService,
        private LoggerInterface $productLogger,
    ) {
    }

    public function createNew(CertificateCreateDTO $requestDTO): CertificateDTO
    {
        $certificate = (new Certificate())
            ->setClientOrder($this->orderService->findEntityById($requestDTO->getClientOrderId()))
            ->setProductPackage($this->packageRepository->findOneBy(['id' => $requestDTO->getProductPackageId()]))
            ->setHash($requestDTO->getHash())
            ->setAmount($requestDTO->getAmount())
            ->setStatus($requestDTO->getStatus())
            ->setCardNumber($requestDTO->getCardNumber())
            ->setPaymentSystem($requestDTO->getPaymentSystem());

        $this->repository->save($certificate);

        return CertificateDTOBuilder::build($certificate);
    }

    public function getList(): array
    {
        $result = [];
        foreach ($this->repository->findAllNotRemoved() as $certificate) {
            $result[] = CertificateDTOBuilder::build($certificate);
        }

        return $result;
    }

    public function view(int $identifier): ?CertificateDTO
    {
        return CertificateDTOBuilder::build(
            $this->repository->findOneBy(['id' => $identifier])
        );
    }

    public function edit(CertificateEditDTO $requestDTO): CertificateDTO
    {
        $certificate = $this->repository->findOneBy(['id' => $requestDTO->getId()]);

        if (null !== $certificate) {
            $order = $certificate->getClientOrder();
            if (null !== $requestDTO->getClientOrderId()) {
                $order = $this->orderService->findEntityById($requestDTO->getClientOrderId());
            }

            $package = $certificate->getProductPackage();
            if (null !== $requestDTO->getProductPackageId()) {
                $package = $this->packageRepository->findOneBy(['id' => $requestDTO->getProductPackageId()]);
            }

            $certificate
                ->setClientOrder($order)
                ->setProductPackage($package)
                ->setHash($requestDTO->getHash() ?? $certificate->getHash())
                ->setAmount($requestDTO->getAmount() ?? $certificate->getAmount())
                ->setStatus($requestDTO->getStatus() ?? $certificate->getStatus())
                ->setCardNumber($requestDTO->getCardNumber() ?? $certificate->getCardNumber())
                ->setPaymentSystem($requestDTO->getPaymentSystem() ?? $certificate->getPaymentSystem());

            $this->repository->save($certificate);
        }

        return CertificateDTOBuilder::build($certificate);
    }

    public function deleteItem(int $identifier): bool
    {
        try {
            $product = $this->repository->findOneBy(['id' => $identifier]);
            if (null !== $product) {
                $product->setStatus(CertificateConstants::STATUS_REMOVED);

                $this->repository->save($product);
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
