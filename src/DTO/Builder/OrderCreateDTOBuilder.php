<?php

declare(strict_types=1);

namespace App\DTO\Builder;

use App\DTO\Request\OrderCreateDTO;

class OrderCreateDTOBuilder
{
    public static function build(array $requestData): OrderCreateDTO
    {
        return (new OrderCreateDTO())
            ->setStatus($requestData['status'] ?? null);
    }
}
