<?php

declare(strict_types=1);

namespace App\DTO\Builder;

use App\DTO\Request\ProjectCreateDTO;

class ProjectCreateDTOBuilder
{
    public static function build(array $requestData): ProjectCreateDTO
    {
        return (new ProjectCreateDTO())
            ->setName($requestData['name'] ?? null)
            ->setStatus($requestData['status'] ?? null);
    }
}
