<?php

namespace App\Base\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

trait DateTimeEntity
{
    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: Types::INTEGER)]
    protected int $createdAt;

    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(type: Types::INTEGER)]
    protected int $updatedAt;

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt->getTimestamp();

        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return \DateTime::createFromFormat('U', (string) $this->createdAt);
    }

    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt->getTimestamp();

        return $this;
    }

    public function getUpdatedAt(): \DateTime
    {
        return \DateTime::createFromFormat('U', (string) $this->updatedAt);
    }
}
