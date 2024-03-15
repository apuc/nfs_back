<?php

declare(strict_types=1);

namespace App\Service\ProjectService\Builder;

use App\Entity\Project;
use App\Service\ProjectService\DTO\ProjectDTO;

class ProjectDTOBuilder
{
    /**
     * @param Project $project
     *
     * @return ProjectDTO|null
     */
    public static function build(Project $project): ?ProjectDTO
    {
        if (null === $project) {
            return null;
        }

        return (new ProjectDTO())
            ->setId($project->getId())
            ->setName($project->getName())
            ->setStatus($project->getStatus())
            ->setCreatedAt(\DateTimeImmutable::createFromMutable($project->getCreatedAt()))
            ->setUpdatedAt(\DateTimeImmutable::createFromMutable($project->getUpdatedAt()));
    }
}
