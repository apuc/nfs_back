<?php

namespace App\DTO\Builder;

use App\DTO\Request\OrderEditDTO;

class OrderEditDTOBuilder
{

    public static function build(int $identifier, array $requestData)
    {
        return (new OrderEditDTO())
            ->setId($identifier)
            ->setStatus($requestData['status'] ?? null);
    }

}