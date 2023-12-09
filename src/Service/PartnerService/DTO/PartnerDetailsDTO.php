<?php

declare(strict_types=1);

namespace App\Service\PartnerService\DTO;

class PartnerDetailsDTO
{
    private ?int $inn = null;
    private ?int $kpp = null;
    private ?int $ogrn = null;
    private ?string $address = null;
    private ?string $bank = null;
    private ?int $bik = null;
    private ?string $accountNumber = null;
    private ?string $corrAccountNumber = null;

    public function getInn(): ?int
    {
        return $this->inn;
    }

    public function setInn(?int $inn): self
    {
        $this->inn = $inn;

        return $this;
    }

    public function getKpp(): ?int
    {
        return $this->kpp;
    }

    public function setKpp(?int $kpp): self
    {
        $this->kpp = $kpp;

        return $this;
    }

    public function getOgrn(): ?int
    {
        return $this->ogrn;
    }

    public function setOgrn(?int $ogrn): self
    {
        $this->ogrn = $ogrn;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getBank(): ?string
    {
        return $this->bank;
    }

    public function setBank(?string $bank): self
    {
        $this->bank = $bank;

        return $this;
    }

    public function getBik(): ?int
    {
        return $this->bik;
    }

    public function setBik(?int $bik): self
    {
        $this->bik = $bik;

        return $this;
    }

    public function getAccountNumber(): ?string
    {
        return $this->accountNumber;
    }

    public function setAccountNumber(?string $accountNumber): self
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    public function getCorrAccountNumber(): ?string
    {
        return $this->corrAccountNumber;
    }

    public function setCorrAccountNumber(?string $corrAccountNumber): self
    {
        $this->corrAccountNumber = $corrAccountNumber;

        return $this;
    }
}
