<?php

declare(strict_types=1);

namespace App\Service\TerminalService\DTO;

class TerminalDTO
{
    private int $id;
    private string $title;
    private string $serial;
    private string $modelName;
    private string $simCardNumber;
    private string $mcamCardNumber;
    private int $status;
    private string $hash;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

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

    public function getSerial(): string
    {
        return $this->serial;
    }

    public function setSerial(string $serial): self
    {
        $this->serial = $serial;

        return $this;
    }

    public function getModelName(): string
    {
        return $this->modelName;
    }

    public function setModelName(string $modelName): self
    {
        $this->modelName = $modelName;

        return $this;
    }

    public function getSimCardNumber(): string
    {
        return $this->simCardNumber;
    }

    public function setSimCardNumber(string $simCardNumber): self
    {
        $this->simCardNumber = $simCardNumber;

        return $this;
    }

    public function getMcamCardNumber(): string
    {
        return $this->mcamCardNumber;
    }

    public function setMcamCardNumber(string $mcamCardNumber): self
    {
        $this->mcamCardNumber = $mcamCardNumber;

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

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
