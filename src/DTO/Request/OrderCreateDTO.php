<?php

declare(strict_types=1);

namespace App\DTO\Request;

use App\Service\OrderService\Constants\OrderConstants;
use Doctrine\DBAL\Types\Types;
use JMS\Serializer\Annotation\Exclude;
use App\Service\Validator\Constraints as AcmeAssert;
use OpenApi\Attributes;

class OrderCreateDTO
{
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
}
