<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductRepository;
use App\Service\ProductService\Constants\ProductConstants;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: 'product', options: ['comment' => 'Справочник услуг'])]
#[ORM\Index(columns: ['partner_id'], name: 'product_partner_idx')]
#[ORM\Index(columns: ['status'], name: 'product_status_idx')]
class Product
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Partner::class, inversedBy: 'products')]
    private Partner $partner;

    #[ORM\ManyToMany(targetEntity: ProductPackage::class)]
    #[ORM\JoinTable(name: 'product_package_product')]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'product_package_id', referencedColumnName: 'id')]
    private Collection $packages;

    #[ORM\Column(type: Types::STRING, length: 200, nullable: false)]
    private string $title;

    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private int $amount;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private int $useCount;

    #[ORM\Column(type: Types::INTEGER, length: 2, nullable: false, options: ['default' => ProductConstants::STATUS_ACTIVE, 'comment' => 'Статус услуги'])]
    private int $status = ProductConstants::STATUS_ACTIVE;

    #[ORM\Column(type: Types::STRING, length: 60, nullable: false)]
    private string $hash;

    public function __construct()
    {
        $this->packages = new ArrayCollection();
    }

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

    public function getProductPackage(): ?Collection
    {
        return $this->packages;
    }

    public function addProductPackage(ProductPackage $package): self
    {
        $this->packages->add($package);

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
}
