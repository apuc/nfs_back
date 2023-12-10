<?php

declare(strict_types=1);

namespace App\DTO\Request;

use App\Service\Validator\Constraints as AcmeAssert;
use Doctrine\DBAL\Types\Types;
use JMS\Serializer\Annotation\Exclude;
use OpenApi\Attributes;

class TerminalCreateDTO
{
    #[Attributes\Property(
        description: 'Наименование',
        type: Types::STRING,
    )]
    #[AcmeAssert\NotEmpty]
    private ?string $title = null;

    #[Attributes\Property(
        description: 'Cерийный номер',
        type: Types::STRING,
    )]
    #[AcmeAssert\NotEmpty]
    private ?string $serial = null;

    #[Attributes\Property(
        description: 'Название модели',
        type: Types::STRING,
    )]
    #[AcmeAssert\NotEmpty]
    private ?string $modelName = null;

    #[Attributes\Property(
        description: 'Номер СИМ-карты',
        type: Types::STRING,
    )]
    #[AcmeAssert\NotEmpty]
    private ?string $simCardNumber = null;

    #[Attributes\Property(
        description: 'Номер MCAM-карты',
        type: Types::STRING,
    )]
    #[AcmeAssert\NotEmpty]
    private ?string $mcamCardNumber = null;

    #[Exclude]
    private string $hash;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSerial(): ?string
    {
        return $this->serial;
    }

    public function setSerial(?string $serial): self
    {
        $this->serial = $serial;

        return $this;
    }

    public function getModelName(): ?string
    {
        return $this->modelName;
    }

    public function setModelName(?string $modelName): self
    {
        $this->modelName = $modelName;

        return $this;
    }

    public function getSimCardNumber(): ?string
    {
        return $this->simCardNumber;
    }

    public function setSimCardNumber(?string $simCardNumber): self
    {
        $this->simCardNumber = $simCardNumber;

        return $this;
    }

    public function getMcamCardNumber(): ?string
    {
        return $this->mcamCardNumber;
    }

    public function setMcamCardNumber(?string $mcamCardNumber): self
    {
        $this->mcamCardNumber = $mcamCardNumber;

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
