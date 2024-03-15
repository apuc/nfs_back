<?php

declare(strict_types=1);

namespace App\DTO\Builder;

use App\DTO\Request\ProjectEditDTO;

class ProjectEditDTOBuilder
{
    public static function build(int $identifier, array $requestData): ProjectEditDTO
    {
        return (new ProjectEditDTO())
            ->setId($identifier)
            ->setName($requestData['name'] ?? null)
            ->setStatus($requestData['status'] ?? null);
    }
}
