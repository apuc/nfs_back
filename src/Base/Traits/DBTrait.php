<?php

declare(strict_types=1);

namespace App\Base\Traits;

trait DBTrait
{
    public function save($entity): void
    {
        $em = $this->getEntityManager();

        $em->persist($entity);
        $em->flush();
    }

    public function remove($entity): void
    {
        $em = $this->getEntityManager();

        $em->remove($entity);
        $em->flush();
    }
}
