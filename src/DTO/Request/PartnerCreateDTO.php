<?php

declare(strict_types=1);

namespace App\DTO\Request;

use App\Service\PartnerService\Constants\PartnerConstants;
use App\Service\Validator\Constraints as AcmeAssert;
use Doctrine\DBAL\Types\Types;
use JMS\Serializer\Annotation\Exclude;
use OpenApi\Attributes;

class PartnerCreateDTO
{
    #[Attributes\Property(
        description: 'Наименование ТСП',
        type: Types::STRING,
    )]
    #[AcmeAssert\NotEmpty]
    private ?string $title = null;

    #[Attributes\Property(
        description: 'Вид дейтельности ТСП',
        type: Types::STRING,
    )]
    #[AcmeAssert\NotEmpty]
    private ?string $occupation = null;

    #[Attributes\Property(
        description: 'ИНН',
        type: Types::INTEGER,
    )]
    #[AcmeAssert\ContainsOnlyDigits]
    #[AcmeAssert\NotEmpty]
    private ?int $inn = null;

    #[Attributes\Property(
        description: 'КПП',
        type: Types::INTEGER,
    )]
    #[AcmeAssert\ContainsOnlyDigits]
    private ?int $kpp = null;

    #[Attributes\Property(
        description: 'ОГРН',
        type: Types::INTEGER,
    )]
    #[AcmeAssert\ContainsOnlyDigits]
    private ?int $ogrn = null;

    #[Attributes\Property(
        description: 'Адрес',
        type: Types::STRING,
    )]
    private ?string $address = null;

    #[Attributes\Property(
        description: 'Наименование банка',
        type: Types::STRING,
    )]
    private ?string $bank = null;

    #[Attributes\Property(
        description: 'БИК банка',
        type: Types::INTEGER,
    )]
    #[AcmeAssert\ContainsOnlyDigits]
    private ?int $bik = null;

    #[Attributes\Property(
        description: 'Расчетный счет',
        type: Types::STRING,
    )]
    private ?string $accountNumber = null;

    #[Attributes\Property(
        description: 'Корр. счет',
        type: Types::STRING,
    )]
    private ?string $corrAccountNumber = null;

    #[Attributes\Property(
        description: 'Номер телефона',
        type: Types::STRING,
    )]
    #[AcmeAssert\NotEmpty]
    #[AcmeAssert\PhoneNumber]
    private ?string $phoneNumber = null;

    #[Attributes\Property(
        description: 'Адрес электронной почты',
        type: Types::STRING,
    )]
    #[AcmeAssert\Email]
    private ?string $email = null;

    #[Exclude]
    private ?int $status = PartnerConstants::STATUS_NEW;

    #[Attributes\Property(
        description: 'Город',
        type: Types::STRING,
    )]
    #[AcmeAssert\CityExists]
    private ?string $city = null;

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

    public function getOccupation(): ?string
    {
        return $this->occupation;
    }

    public function setOccupation(?string $occupation): self
    {
        $this->occupation = $occupation;

        return $this;
    }

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

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
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
}
