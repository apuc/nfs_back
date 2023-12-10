<?php

declare(strict_types=1);

namespace App\DTO\Request;

use App\Service\Validator\Constraints as AcmeAssert;
use Doctrine\DBAL\Types\Types;
use JMS\Serializer\Annotation\Exclude;
use OpenApi\Attributes;

class ProductPackageEditDTO
{
    #[Exclude]
    private int $id;

    #[Attributes\Property(
        description: 'Наименование',
        type: Types::STRING,
    )]
    private ?string $title = null;

    #[Attributes\Property(
        description: 'Стоимость',
        type: Types::INTEGER,
    )]
    #[AcmeAssert\ContainsOnlyDigits]
    private ?int $amount = null;

    #[Attributes\Property(
        description: 'Срок действия',
        type: Types::STRING,
    )]
    private ?\DateTime $finishedAt = null;

    #[Attributes\Property(
        description: 'Тип пакета: 1 - полный, 2 - частичный',
        type: Types::INTEGER,
    )]
    #[AcmeAssert\ContainsOnlyDigits]
    private ?int $type = null;

    #[Exclude]
    private string $hash;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(?int $amount): self
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

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): self
    {
        $this->type = $type;

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
