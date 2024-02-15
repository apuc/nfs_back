<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TerminalRepository;
use App\Service\TerminalService\Constants\TerminalConstants;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: TerminalRepository::class)]
#[ORM\Table(name: 'terminal', options: ['comment' => 'Справочник терминалов'])]
class Terminal
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private int $id;

    #[ORM\Column(type: Types::STRING, length: 200, nullable: false)]
    private string $title;

    #[ORM\Column(type: Types::STRING, length: 200, nullable: false)]
    private string $serial;

    #[ORM\Column(type: Types::STRING, length: 200, nullable: false)]
    private string $modelName;

    #[ORM\Column(type: Types::STRING, length: 200, nullable: false)]
    private string $simCardNumber;

    #[ORM\Column(type: Types::STRING, length: 200, nullable: false)]
    private string $mcamCardNumber;

    #[ORM\Column(type: Types::INTEGER, length: 2, nullable: false, options: ['default' => TerminalConstants::STATUS_ACTIVE])]
    private int $status = TerminalConstants::STATUS_ACTIVE;

    #[ORM\Column(type: Types::STRING, length: 60, nullable: false)]
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
}
