<?php

declare(strict_types=1);

namespace App\DTO\Request;

use App\Service\CertificateService\Constants\CertificateConstants;
use App\Service\Validator\Constraints as AcmeAssert;
use Doctrine\DBAL\Types\Types;
use JMS\Serializer\Annotation\Exclude;
use OpenApi\Attributes;

class CertificateEditDTO
{
    #[Exclude]
    private int $id;

    #[Attributes\Property(
        description: 'Идентификатор пакета услуг',
        type: Types::INTEGER,
    )]
    #[AcmeAssert\ContainsOnlyDigits]
    #[AcmeAssert\ProductPackageExists]
    private ?int $productPackageId = null;

    #[Attributes\Property(
        description: 'Идентификатор заказа',
        type: Types::INTEGER,
    )]
    #[AcmeAssert\ContainsOnlyDigits]
    #[AcmeAssert\OrderExists]
    private ?int $clientOrderId = null;

    #[Attributes\Property(
        description: 'Хеш',
        type: Types::STRING,
    )]
    private ?string $hash = null;

    #[Attributes\Property(
        description: 'Сумма',
        type: Types::INTEGER,
    )]
    #[AcmeAssert\ContainsOnlyDigits]
    private ?int $amount = null;

    #[Attributes\Property(
        description: 'Статус',
        type: Types::INTEGER,
    )]
    #[AcmeAssert\ContainsOnlyDigits]
    private ?int $status = CertificateConstants::STATUS_NEW;

    #[Attributes\Property(
        description: 'Номер карты',
        type: Types::STRING,
    )]
    private ?string $cardNumber = null;

    #[Attributes\Property(
        description: 'Платежная система',
        type: Types::STRING,
    )]
    private ?string $paymentSystem = null;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return CertificateEditDTO
     */
    public function setId(int $id): CertificateEditDTO
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getProductPackageId(): ?int
    {
        return $this->productPackageId;
    }

    /**
     * @param int|null $productPackageId
     *
     * @return CertificateCreateDTO
     */
    public function setProductPackageId(?int $productPackageId): self
    {
        $this->productPackageId = $productPackageId;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getClientOrderId(): ?int
    {
        return $this->clientOrderId;
    }

    /**
     * @param int|null $clientOrderId
     *
     * @return CertificateCreateDTO
     */
    public function setClientOrderId(?int $clientOrderId): self
    {
        $this->clientOrderId = $clientOrderId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHash(): ?string
    {
        return $this->hash;
    }

    /**
     * @param string|null $hash
     *
     * @return CertificateCreateDTO
     */
    public function setHash(?string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getAmount(): ?int
    {
        return $this->amount;
    }

    /**
     * @param int|null $amount
     *
     * @return CertificateCreateDTO
     */
    public function setAmount(?int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int|null $status
     *
     * @return CertificateCreateDTO
     */
    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCardNumber(): ?string
    {
        return $this->cardNumber;
    }

    /**
     * @param string|null $cardNumber
     *
     * @return CertificateCreateDTO
     */
    public function setCardNumber(?string $cardNumber): self
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPaymentSystem(): ?string
    {
        return $this->paymentSystem;
    }

    /**
     * @param string|null $paymentSystem
     *
     * @return CertificateCreateDTO
     */
    public function setPaymentSystem(?string $paymentSystem): self
    {
        $this->paymentSystem = $paymentSystem;

        return $this;
    }


}
