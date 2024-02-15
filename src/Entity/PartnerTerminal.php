<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TerminalRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: TerminalRepository::class)]
#[ORM\Table(name: 'partner_terminal')]
#[ORM\Index(columns: ['partner_id'], name: 'partner_link_idx')]
#[ORM\Index(columns: ['terminal_id'], name: 'terminal_link_idx')]
#[ORM\Index(columns: ['product_package_id'], name: 'product_package_link_idx')]
class PartnerTerminal
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Partner::class)]
    private Partner $partner;

    #[ORM\ManyToOne(targetEntity: Terminal::class)]
    private Terminal $terminal;

    #[ORM\ManyToOne(targetEntity: ProductPackage::class)]
    private ProductPackage $productPackage;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: false)]
    private ?\DateTime $transferredAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: false)]
    private ?\DateTime $returnedAt = null;

    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private int $cost;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getPartner(): Partner
    {
        return $this->partner;
    }

    public function setPartner(Partner $partner): self
    {
        $this->partner = $partner;

        return $this;
    }

    public function getTerminal(): Terminal
    {
        return $this->terminal;
    }

    public function setTerminal(Terminal $terminal): self
    {
        $this->terminal = $terminal;

        return $this;
    }

    public function getProductPackage(): ProductPackage
    {
        return $this->productPackage;
    }

    public function setProductPackage(ProductPackage $productPackage): self
    {
        $this->productPackage = $productPackage;

        return $this;
    }

    public function getTransferredAt(): ?\DateTime
    {
        return $this->transferredAt;
    }

    public function setTransferredAt(?\DateTime $transferredAt): self
    {
        $this->transferredAt = $transferredAt;

        return $this;
    }

    public function getReturnedAt(): ?\DateTime
    {
        return $this->returnedAt;
    }

    public function setReturnedAt(?\DateTime $returnedAt): self
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
}
