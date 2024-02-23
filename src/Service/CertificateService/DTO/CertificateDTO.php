<?php

declare(strict_types=1);

namespace App\Service\CertificateService\DTO;

use App\Service\OrderService\DTO\OrderDTO;
use App\Service\ProductService\DTO\ProductPackageDTO;

class CertificateDTO
{
    private int $id;
    private OrderDTO $clientOrder;
    private ProductPackageDTO $package;
    private ?string $hash = null;
    private ?int $amount = null;
    private int $status;
    private ?string $cardNumber = null;
    private ?string $paymentSystem = null;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

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
     * @return CertificateDTO
     */
    public function setId(int $id): CertificateDTO
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return OrderDTO
     */
    public function getClientOrder(): OrderDTO
    {
        return $this->clientOrder;
    }

    /**
     * @param OrderDTO $clientOrder
     *
     * @return CertificateDTO
     */
    public function setClientOrder(OrderDTO $clientOrder): CertificateDTO
    {
        $this->clientOrder = $clientOrder;

        return $this;
    }

    /**
     * @return ProductPackageDTO
     */
    public function getPackage(): ProductPackageDTO
    {
        return $this->package;
    }

    /**
     * @param ProductPackageDTO $package
     *
     * @return CertificateDTO
     */
    public function setPackage(ProductPackageDTO $package): CertificateDTO
    {
        $this->package = $package;

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
     * @return CertificateDTO
     */
    public function setHash(?string $hash): CertificateDTO
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
     * @return CertificateDTO
     */
    public function setAmount(?int $amount): CertificateDTO
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     *
     * @return CertificateDTO
     */
    public function setStatus(int $status): CertificateDTO
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
     * @return CertificateDTO
     */
    public function setCardNumber(?string $cardNumber): CertificateDTO
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
     * @return CertificateDTO
     */
    public function setPaymentSystem(?string $paymentSystem): CertificateDTO
    {
        $this->paymentSystem = $paymentSystem;

        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeImmutable $createdAt
     *
     * @return CertificateDTO
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): CertificateDTO
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeImmutable $updatedAt
     *
     * @return CertificateDTO
     */
    public function setUpdatedAt(\DateTimeImmutable $updatedAt): CertificateDTO
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }


}
