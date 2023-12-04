<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PartnerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: PartnerRepository::class)]
#[ORM\Table(name: 'partner', options: ['comment' => 'Справочник ТСП'])]
class Partner
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private int $id;

    #[ORM\Column(type: Types::STRING, length: 200, nullable: false)]
    private string $name;

    #[ORM\Column(type: Types::JSON, nullable: true, options: ['jsonb' => true, 'comment' => 'Реквизиты компании'])]
    private array $details = [];

    #[ORM\Column(type: Types::JSON, nullable: true, options: ['jsonb' => true, 'comment' => 'Контакты'])]
    private array $contacts = [];

    #[ORM\Column(type: Types::STRING, length: 100, nullable: true, options: ['comment' => 'Направление деятельности'])]
    private ?string $occupation = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDetails(): array
    {
        return $this->details;
    }

    public function getDetailsByKey(string $key): ?string
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
}
