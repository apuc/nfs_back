<?php

declare(strict_types=1);

namespace App\DTO\Request;

use App\Service\Validator\Constraints as AcmeAssert;
use Doctrine\DBAL\Types\Types;
use OpenApi\Attributes;

class RegionCreateDTO
{
    #[Attributes\Property(
        description: 'Наименование региона',
        type: Types::STRING,
    )]
    #[AcmeAssert\NotEmpty]
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
     * @return RegionCreateDTO
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }


}
