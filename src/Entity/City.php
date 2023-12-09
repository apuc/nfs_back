<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: CityRepository::class)]
#[ORM\Table(name: 'city', options: ['comment' => 'Справочник городов'])]
#[ORM\Index(columns: ['title'], name: 'city_title_idx')]
#[ORM\Index(columns: ['region_id'], name: 'city_region_idx')]
class City
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private int $id;

    #[ORM\Column(type: Types::STRING, length: 200, nullable: false)]
    private string $title;

    #[ORM\ManyToOne(targetEntity: Region::class, inversedBy: 'cities')]
    private Region $region;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getRegion(): Region
    {
        return $this->region;
    }

    public function setRegion(Region $region): void
    {
        $this->region = $region;
    }
}
