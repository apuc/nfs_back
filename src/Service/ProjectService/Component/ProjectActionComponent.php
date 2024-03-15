<?php

declare(strict_types=1);

namespace App\Service\ProjectService\Component;

use App\DTO\Builder\ProjectCreateDTOBuilder;
use App\DTO\Request\ProjectCreateDTO;
use App\DTO\Request\ProjectEditDTO;
use App\Entity\Project;
use App\Repository\ProjectRepository;
use App\Service\ProjectService\Builder\ProjectDTOBuilder;
use App\Service\ProjectService\Constants\ProjectConstants;
use App\Service\ProjectService\DTO\ProjectDTO;
use App\Service\ProjectService\ProjectService;
use Psr\Log\LoggerInterface;

class ProjectActionComponent
{

    public function __construct(
        private ProjectRepository $repository,
        private ProjectService $service,
        private LoggerInterface $orderLogger,
    )
    {
    }

    public function createNew(ProjectCreateDTO $createDTO): ProjectDTO
    {
        $order = (new Project())
            ->setName($createDTO->getName())
            ->setStatus(ProjectConstants::STATUS_NEW);

        $this->repository->save($order);

        return ProjectDTOBuilder::build($order);
    }

    public function getList(): array
    {
        $result = [];
        foreach ($this->repository->findAllNotRemoved() as $order) {
            $result[] = ProjectDTOBuilder::build($order);
        }

        return $result;
    }

    public function view(int $identifier): ?ProjectDTO
    {
        return ProjectDTOBuilder::build(
            $this->repository->findOneBy(['id' => $identifier])
        );
    }

    public function edit(ProjectEditDTO $editDTO): ProjectDTO
    {
        $project = $this->service->getById($editDTO->getId());

        if (null !== $project) {
            $project->setName($editDTO->getName() ?? $project->getName());
            $project->setStatus($editDTO->getStatus() ?? $project->getStatus());

            $this->repository->save($project);
        }

        return ProjectDTOBuilder::build($project);
    }

    public function deleteItem(int $identifier): bool
    {
        try {
            $partner = $this->repository->findOneBy(['id' => $identifier]);
            if (null !== $partner) {
                $partner->setStatus(ProjectConstants::STATUS_REMOVED);

                $this->repository->save($partner);
            }

            return true;
        } catch (\Throwable $exception) {
            $this->orderLogger->critical(
                'Error when project remove: '.$exception->getMessage(),
                [
                    'identifier' => $identifier,
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                ]
            );

            return false;
        }
    }

}