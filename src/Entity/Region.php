<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\RegionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: RegionRepository::class)]
#[ORM\Table(name: 'region', options: ['comment' => 'Справочник регионов'])]
class Region
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private int $id;

    #[ORM\Column(type: Types::STRING, length: 200, nullable: false)]
    private string $title;

    #[ORM\OneToMany(mappedBy: 'region', targetEntity: City::class)]
    private ?PersistentCollection $cities = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCities(): ?PersistentCollection
    {
        return $this->cities;
    }

    public function addCity(City $city): self
    {
        $this->cities->add($city);

        return $this;
    }
}
