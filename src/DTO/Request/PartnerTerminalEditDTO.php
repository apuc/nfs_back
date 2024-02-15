<?php

declare(strict_types=1);

namespace App\DTO\Request;

use Doctrine\DBAL\Types\Types;
use JMS\Serializer\Annotation\Exclude;

class PartnerTerminalEditDTO
{
    #[Exclude]
    private int $id;

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
        description: 'Идентификатор терминала',
        type: Types::INTEGER,
    )]
    #[AcmeAssert\ContainsOnlyDigits]
    #[AcmeAssert\TerminalExists]
    #[AcmeAssert\NotEmpty]
    private ?int $terminalId = null;

    #[Attributes\Property(
        description: 'Дата передачи',
        type: Types::STRING,
        example: '2023-06-06T16:43:02'
    )]
    #[AcmeAssert\NotEmpty]
    private ?\DateTime $transferredAt = null;

    #[Attributes\Property(
        description: 'Дата возврата',
        type: Types::STRING,
        example: '2023-06-06T16:43:02'
    )]
    #[AcmeAssert\NotEmpty]
    private ?\DateTime $returnedAt = null;

    #[AcmeAssert\ContainsOnlyDigits]
    #[Attributes\Property(
        description: 'Комиссия/стоимость аренды',
        type: Types::INTEGER,
    )]
    private ?int $cost = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getPartnerId(): ?int
    {
        return $this->partnerId;
    }

    public function setPartnerId(int $partnerId): self
    {
        $this->partnerId = $partnerId;

        return $this;
    }

    public function getTerminalId(): ?int
    {
        return $this->terminalId;
    }

    public function setTerminalId(int $terminalId): self
    {
        $this->terminalId = $terminalId;

        return $this;
    }

    public function getPackageId(): ?int
    {
        return $this->packageId;
    }

    public function setPackageId(int $packageId): self
    {
        $this->packageId = $packageId;

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

    public function getCost(): ?int
    {
        return $this->cost;
    }

    public function setCost(?int $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

}