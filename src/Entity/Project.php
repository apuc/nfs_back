<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use App\Service\ProjectService\Constants\ProjectConstants;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[ORM\Table(name: 'project', options: ['comment' => 'Справочник Проектов'])]
#[ORM\Index(columns: ['status'], name: 'project_status_idx')]
class Project
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: false)]
    private ?string $name = null;

    #[ORM\Column(type: Types::INTEGER, length: 2, nullable: false, options: ['default' => ProjectConstants::STATUS_NEW, 'comment' => 'Статус проекта'])]
    private ?int $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }
}
