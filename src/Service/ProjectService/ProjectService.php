<?php

declare(strict_types=1);

namespace App\Service\ProjectService;

use App\Repository\ProjectRepository;

class ProjectService
{

    public function __construct(
        private ProjectRepository $repository
    ) {
    }

    public function getById(int $id)
    {
        return $this->repository->findOneBy(['id' => $id]);
    }

}