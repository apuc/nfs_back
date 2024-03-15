<?php

declare(strict_types=1);

namespace App\DTO\Request;

use App\Service\ProjectService\Constants\ProjectConstants;
use App\Service\Validator\Constraints as AcmeAssert;
use Doctrine\DBAL\Types\Types;
use OpenApi\Attributes;

class ProjectCreateDTO
{
    #[Attributes\Property(
        description: 'Наименование',
        type: Types::STRING,
    )]
    #[AcmeAssert\NotEmpty]
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
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int|null $status
     *
     * @return ProjectCreateDTO
     */
    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }


}
