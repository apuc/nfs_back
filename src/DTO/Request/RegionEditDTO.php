<?php

declare(strict_types=1);

namespace App\DTO\Request;

use App\Service\Validator\Constraints as AcmeAssert;
use Doctrine\DBAL\Types\Types;
use JMS\Serializer\Annotation\Exclude;
use OpenApi\Attributes;

class RegionEditDTO
{
    #[Exclude]
    private int $id;

    #[Attributes\Property(
        description: 'Наименование региона',
        type: Types::STRING,
    )]
    private ?string $title = null;

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     *
     * @return RegionEditDTO
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

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
     * @return RegionEditDTO
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }


}
