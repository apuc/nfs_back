<?php

declare(strict_types=1);

namespace App\DTO\Request;

use App\Service\Validator\Constraints as AcmeAssert;
use Doctrine\DBAL\Types\Types;
use JMS\Serializer\Annotation\Exclude;
use OpenApi\Attributes;

class ProductCreateDTO
{
    #[Attributes\Property(
        description: 'Идентификатор ТСП',
        type: Types::INTEGER,
    )]
    #[AcmeAssert\ContainsOnlyDigits]
    #[AcmeAssert\PartnerExists]
    #[AcmeAssert\NotEmpty]
    private ?int $partnerId = null;

    #[Attributes\Property(
        description: 'Идентификатор пакета услуг',
        type: Types::INTEGER,
    )]
    #[AcmeAssert\ContainsOnlyDigits]
    #[AcmeAssert\ProductPackageExists]
    #[AcmeAssert\NotEmpty]
    private ?int $packageId = null;

    #[Attributes\Property(
        description: 'Наименование',
        type: Types::STRING,
    )]
    #[AcmeAssert\NotEmpty]
    private ?string $title = null;

    #[Attributes\Property(
        description: 'Стоимость',
        type: Types::INTEGER,
    )]
    #[AcmeAssert\ContainsOnlyDigits]
    #[AcmeAssert\NotEmpty]
    private ?int $amount = null;

    #[Attributes\Property(
        description: 'Описание',
        type: Types::STRING,
    )]
    private ?string $description = null;

    #[Attributes\Property(
        description: 'Кол-во использований услуги',
        type: Types::INTEGER,
    )]
    #[AcmeAssert\ContainsOnlyDigits]
    #[AcmeAssert\NotEmpty]
    private ?int $useCount = null;

    #[Exclude]
    private string $hash;

    public function getPartnerId(): ?int
    {
        return $this->partnerId;
    }

    public function setPartnerId(?int $partnerId): self
    {
        $this->partnerId = $partnerId;

        return $this;
    }

    public function getPackageId(): ?int
    {
        return $this->packageId;
    }

    public function setPackageId(?int $packageId): self
    {
        $this->packageId = $packageId;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUseCount(): ?int
    {
        return $this->useCount;
    }

    public function setUseCount(?int $useCount): self
    {
        $this->useCount = $useCount;

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
