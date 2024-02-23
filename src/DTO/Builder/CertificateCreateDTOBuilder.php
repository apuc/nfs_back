<?php

declare(strict_types=1);

namespace App\DTO\Builder;

use App\DTO\Request\CertificateCreateDTO;

class CertificateCreateDTOBuilder
{
    public static function build(array $requestData)
    {
        return (new CertificateCreateDTO())
            ->setClientOrderId($requestData['client_order_id'] ?? null)
            ->setProductPackageId($requestData['product_package_id'] ?? null)
            ->setHash($requestData['hash'] ?? null)
            ->setAmount($requestData['amount'] ?? null)
            ->setStatus($requestData['status'] ?? null)
            ->setCardNumber($requestData['card_number'] ?? null)
            ->setPaymentSystem($requestData['payment_system'] ?? null);
    }
}
