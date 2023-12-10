<?php

declare(strict_types=1);

namespace App\Service\PartnerService\DTO;

use App\Service\GeoService\DTO\CityDTO;
use DateTimeImmutable;

class PartnerDTO
{
    private int $id;
    private CityDTO $city;
    private string $title;
    private PartnerDetailsDTO $details;
    private PartnerContactsDTO $contacts;
    private ?string $occupation = null;
    private int $status;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getCity(): CityDTO
    {
        return $this->city;
    }

    public function setCity(CityDTO $city): self
    {
        $this->city = $city;

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

    public function getDetails(): PartnerDetailsDTO
    {
        return $this->details;
    }

    public function setDetails(PartnerDetailsDTO $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getContacts(): PartnerContactsDTO
    {
        return $this->contacts;
    }

    public function setContacts(PartnerContactsDTO $contacts): self
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

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
