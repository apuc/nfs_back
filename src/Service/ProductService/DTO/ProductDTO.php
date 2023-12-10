<?php

declare(strict_types=1);

namespace App\Service\ProductService\DTO;

use App\Service\PartnerService\DTO\PartnerDTO;

class ProductDTO
{
    private int $id;
    private PartnerDTO $partner;
    private ProductPackageDTO $package;
    private string $title;
    private int $amount;
    private ?string $description = null;
    private int $useCount;
    private int $status;
    private string $hash;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getPartner(): PartnerDTO
    {
        return $this->partner;
    }

    public function setPartner(PartnerDTO $partner): self
    {
        $this->partner = $partner;

        return $this;
    }

    public function getPackage(): ProductPackageDTO
    {
        return $this->package;
    }

    public function setPackage(ProductPackageDTO $package): self
    {
        $this->package = $package;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUseCount(): int
    {
        return $this->useCount;
    }

    public function setUseCount(int $useCount): self
    {
        $this->useCount = $useCount;

        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
