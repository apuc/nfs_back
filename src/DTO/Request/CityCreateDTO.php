<?php

declare(strict_types=1);

namespace App\DTO\Request;

use App\Service\Validator\Constraints as AcmeAssert;
use Doctrine\DBAL\Types\Types;
use OpenApi\Attributes;

class CityCreateDTO
{
    #[Attributes\Property(
        description: 'Наименование города',
        type: Types::STRING,
    )]
    #[AcmeAssert\NotEmpty]
    private ?string $title = null;

    #[Attributes\Property(
        description: 'Идентификатор региона',
        type: Types::INTEGER,
    )]
    #[AcmeAssert\NotEmpty]
    private int $regionId;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getRegionId(): int
    {
        return $this->regionId;
    }

    public function setRegionId(int $regionId): self
    {
        $this->regionId = $regionId;

        return $this;
    }
}
