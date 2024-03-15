<?php

declare(strict_types=1);

namespace App\DTO\Request;

use App\Service\ProjectService\Constants\ProjectConstants;
use App\Service\Validator\Constraints as AcmeAssert;
use Doctrine\DBAL\Types\Types;
use JMS\Serializer\Annotation\Exclude;
use OpenApi\Attributes;

class ProjectEditDTO
{
    #[Exclude]
    private int $id;

    #[Attributes\Property(
        description: 'Наименование',
        type: Types::STRING,
    )]
    private ?string $name;

    #[Attributes\Property(
        description: 'Статус',
        type: Types::INTEGER,
    )]
    #[AcmeAssert\ContainsOnlyDigits]
    private ?int $status = ProjectConstants::STATUS_NEW;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return ProjectEditDTO
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int|null $status
     *
     * @return ProjectEditDTO
     */
    public function setStatus(?int $status): ProjectEditDTO
    {
        $this->status = $status;

        return $this;
    }



}
