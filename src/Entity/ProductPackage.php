<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductPackageRepository;
use App\Service\ProductService\Constants\ProductConstants;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: ProductPackageRepository::class)]
#[ORM\Table(name: 'product_package', options: ['comment' => 'Справочник пакетов услуг'])]
class ProductPackage
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private int $id;

    #[ORM\Column(type: Types::STRING, length: 200, nullable: false)]
    private string $title;

    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private int $amount;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTime $finishedAt = null;

    #[ORM\Column(type: Types::INTEGER, length: 1, nullable: false)]
    private int $type = ProductConstants::FULL;

    #[ORM\Column(type: Types::INTEGER, length: 2, nullable: false, options: [
        'default' => ProductConstants::STATUS_ACTIVE,
        'comment' => 'Статус пакета услуг',
    ])]
    private int $status = ProductConstants::STATUS_ACTIVE;


    #[ORM\ManyToMany(targetEntity: 'Product')]
    #[ORM\JoinTable(name: 'product_package_product')]
    #[ORM\JoinColumn(name: 'product_package_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'product_id', referencedColumnName: 'id')]
    private ?Collection $products;

    #[ORM\Column(type: Types::STRING, length: 60, nullable: false)]
    private string $hash;

    public function __construct()
    {
        $this->products = new ArrayCollection();
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

    public function getFinishedAt(): ?\DateTime
    {
        return $this->finishedAt;
    }

    public function setFinishedAt(?\DateTime $finishedAt): self
    {
        $this->finishedAt = $finishedAt;

        return $this;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

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

    public function getProducts(): ?Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        $this->products->add($product);

        $product->addProductPackage($this);

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
