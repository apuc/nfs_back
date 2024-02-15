<?php

declare(strict_types=1);

namespace App\Service\PartnerTerminalService;

use App\Service\PartnerService\DTO\PartnerDTO;
use App\Service\ProductService\DTO\ProductPackageDTO;
use App\Service\TerminalService\DTO\TerminalDTO;

class PartnerTerminalDTO
{
    private int $id;
    private PartnerDTO $partner;
    private TerminalDTO $terminal;
    private ProductPackageDTO $productPackage;
    private \DateTime $transferredAt;
    private \DateTime $returnedAt;
    private int $cost;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;

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

    public function getTransferredAt(): \DateTime
    {
        return $this->transferredAt;
    }

    public function setTransferredAt(\DateTime $transferredAt): self
    {
        $this->transferredAt = $transferredAt;

        return $this;
    }

    public function getReturnedAt(): \DateTime
    {
        return $this->returnedAt;
    }

    public function setReturnedAt(\DateTime $returnedAt): self
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

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
