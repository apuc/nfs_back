<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PartnerRepository;
use App\Service\PartnerService\Constants\PartnerConstants;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: PartnerRepository::class)]
#[ORM\Table(name: 'partner', options: ['comment' => 'Справочник ТСП'])]
#[ORM\Index(columns: ['status'], name: 'partner_status_idx')]
class Partner
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private int $id;

    #[ORM\ManyToOne(targetEntity: City::class, inversedBy: 'partners')]
    private City $city;

    #[ORM\Column(type: Types::STRING, length: 200, nullable: false)]
    private string $title;

    #[ORM\Column(type: Types::JSON, nullable: true, options: ['jsonb' => true, 'comment' => 'Реквизиты компании'])]
    private array $details = [];

    #[ORM\Column(type: Types::JSON, nullable: true, options: ['jsonb' => true, 'comment' => 'Контакты'])]
    private array $contacts = [];

    #[ORM\Column(type: Types::STRING, length: 100, nullable: true, options: ['comment' => 'Направление деятельности'])]
    private ?string $occupation = null;

    #[ORM\Column(type: Types::INTEGER, length: 2, nullable: false, options: ['default' => PartnerConstants::STATUS_NEW, 'comment' => 'Статус ТСП'])]
    private int $status = PartnerConstants::STATUS_NEW;

    #[ORM\Column(type: Types::STRING, length: 60, nullable: false)]
    private string $hash;

    #[ORM\OneToMany(mappedBy: 'partner', targetEntity: Product::class)]
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

    public function getDetails(): array
    {
        return $this->details;
    }

    public function getDetailsByKey(string $key): null|string|int
    {
        return $this->details[$key] ?? null;
    }

    public function setDetails(array $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getContacts(): array
    {
        return $this->contacts;
    }

    public function getContactsByKey(string $key): ?string
    {
        return $this->contacts[$key] ?? null;
    }

    public function setContacts(array $contacts): self
    {
        $this->contacts = $contacts;

        return $this;
    }

    public function getOccupation(): ?string
    {
        return $this->occupation;
    }

    public function setOccupation(?string $occupation): self
    {
        $this->occupation = $occupation;

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

    public function getCity(): City
    {
        return $this->city;
    }

    public function setCity(City $city): self
    {
        $this->city = $city;

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
