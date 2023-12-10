<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductPackageRepository;
use App\Service\ProductService\Constants\ProductConstants;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
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
    private ?DateTime $finishedAt = null;

    #[ORM\Column(type: Types::INTEGER, length: 1, nullable: false)]
    private int $type = ProductConstants::FULL;

    #[ORM\OneToMany(mappedBy: 'productPackage', targetEntity: Product::class)]
    private ?PersistentCollection $products = null;

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

    public function getFinishedAt(): ?DateTime
    {
        return $this->finishedAt;
    }

    public function setFinishedAt(?DateTime $finishedAt): self
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

    public function getProducts(): ?PersistentCollection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        $this->products->add($product);

        return $this;
    }
}
