<?php

declare(strict_types=1);

namespace App\Service\TerminalService\DTO;

use App\Service\PartnerService\DTO\PartnerDTO;
use App\Service\ProductService\DTO\ProductPackageDTO;

class PartnerTerminalDTO
{
    private int $id;
    private PartnerDTO $partner;
    private TerminalDTO $terminal;
    private ProductPackageDTO $productPackage;
    private ?\DateTimeImmutable $transferredAt = null;
    private ?\DateTimeImmutable $returnedAt = null;
    private int $cost;
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

    public function getTerminal(): TerminalDTO
    {
        return $this->terminal;
    }

    public function setTerminal(TerminalDTO $terminal): self
    {
        $this->terminal = $terminal;

        return $this;
    }

    public function getProductPackage(): ProductPackageDTO
    {
        return $this->productPackage;
    }

    public function setProductPackage(ProductPackageDTO $productPackage): self
    {
        $this->productPackage = $productPackage;

        return $this;
    }

    public function getTransferredAt(): ?\DateTimeImmutable
    {
        return $this->transferredAt;
    }

    public function setTransferredAt(?\DateTimeImmutable $transferredAt): self
    {
        $this->transferredAt = $transferredAt;

        return $this;
    }

    public function getReturnedAt(): ?\DateTimeImmutable
    {
        return $this->returnedAt;
    }

    public function setReturnedAt(?\DateTimeImmutable $returnedAt): self
    {
        $this->returnedAt = $returnedAt;

        return $this;
    }

    public function getCost(): int
    {
        return $this->cost;
    }

    public function setCost(int $cost): self
    {
        $this->cost = $cost;

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
