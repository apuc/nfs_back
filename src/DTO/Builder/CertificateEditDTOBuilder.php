<?php

declare(strict_types=1);

namespace App\DTO\Builder;

use App\DTO\Request\CertificateCreateDTO;
use App\DTO\Request\CertificateEditDTO;

class CertificateEditDTOBuilder
{
    public static function build(int $identifier, array $requestData)
    {
        return (new CertificateEditDTO())
            ->setId($identifier)
            ->setClientOrderId($requestData['client_order_id'] ?? null)
            ->setProductPackageId($requestData['product_package_id'] ?? null)
            ->setHash($requestData['hash'] ?? null)
            ->setAmount($requestData['amount'] ?? null)
            ->setStatus($requestData['status'] ?? null)
            ->setCardNumber($requestData['card_number'] ?? null)
            ->setPaymentSystem($requestData['payment_system'] ?? null);
    }
}
