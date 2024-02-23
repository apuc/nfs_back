<?php

declare(strict_types=1);

namespace App\Service\CertificateService\Builder;

use App\Entity\Certificate;
use App\Service\CertificateService\DTO\CertificateDTO;
use App\Service\OrderService\Builder\OrderDTOBuilder;
use App\Service\ProductService\Builder\ProductPackageDTOBuilder;

class CertificateDTOBuilder
{
    public static function build(Certificate $certificate = null): ?CertificateDTO
    {
        if (null === $certificate) {
            return null;
        }

        return (new CertificateDTO())
            ->setId($certificate->getId())
            ->setClientOrder(OrderDTOBuilder::build($certificate->getClientOrder()))
            ->setPackage(ProductPackageDTOBuilder::build($certificate->getProductPackage()))
            ->setHash($certificate->getHash())
            ->setAmount($certificate->getAmount())
            ->setStatus($certificate->getStatus())
            ->setCardNumber($certificate->getCardNumber())
            ->setPaymentSystem($certificate->getPaymentSystem())
            ->setCreatedAt(\DateTimeImmutable::createFromMutable($certificate->getCreatedAt()))
            ->setUpdatedAt(\DateTimeImmutable::createFromMutable($certificate->getUpdatedAt()));
    }
}
