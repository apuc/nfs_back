<?php

declare(strict_types=1);

namespace App\DTO\Request;

use App\Service\Validator\Constraints as AcmeAssert;
use Doctrine\DBAL\Types\Types;
use JMS\Serializer\Annotation\Exclude;
use OpenApi\Attributes;

class CityEditDTO
{
    #[Exclude]
    private int $id;

    #[Attributes\Property(
        description: 'Наименование города',
        type: Types::STRING,
    )]
    private ?string $title = null;

    #[Attributes\Property(
        description: 'Идентификатор региона',
        type: Types::INTEGER,
    )]
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
     * @return CityEditDTO
     */
    public function setId(int $id): CityEditDTO
    {
        $this->id = $id;

        return $this;
    }


}
