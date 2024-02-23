<?php

declare(strict_types=1);

namespace App\DTO\Request;

use App\Service\OrderService\Constants\OrderConstants;
use App\Service\Validator\Constraints as AcmeAssert;
use Doctrine\DBAL\Types\Types;
use JMS\Serializer\Annotation\Exclude;
use OpenApi\Attributes;

class OrderEditDTO
{
    #[Exclude]
    private int $id;

    #[Attributes\Property(
        description: 'Статус',
        type: Types::INTEGER,
    )]
    #[AcmeAssert\ContainsOnlyDigits]
    private ?int $status = OrderConstants::STATUS_NEW;

    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @return $this
     */
    public function setStatus(?int $status): self
    {
        $this->status = $status;

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
     * @return OrderEditDTO
     */
    public function setId(int $id): OrderEditDTO
    {
        $this->id = $id;

        return $this;
    }
}
