<?php

declare(strict_types=1);

namespace App\DTO\Builder;

use App\DTO\Request\ProductPackageEditDTO;

class ProductPackageEditDTOBuilder
{
    public static function build(int $identifier, array $requestData): ProductPackageEditDTO
    {
        $finishedAt = null;
        if (!empty($requestData['finished_at'])) {
            $finishedAt = new \DateTime($requestData['finished_at']);
        }

        return (new ProductPackageEditDTO())
            ->setId($identifier)
            ->setTitle($requestData['title'] ?? null)
            ->setAmount($requestData['amount'] ?? null)
            ->setFinishedAt($finishedAt)
            ->setType($requestData['type'] ?? null)
            ->setHash(md5(json_encode($requestData)));
    }
}
