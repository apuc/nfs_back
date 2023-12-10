<?php

declare(strict_types=1);

namespace App\DTO\Builder;

use App\DTO\Request\ProductPackageCreateDTO;

class ProductPackageCreateDTOBuilder
{
    public static function build(array $requestData): ProductPackageCreateDTO
    {
        $finishedAt = null;
        if (!empty($requestData['finished_at'])) {
            $finishedAt = new \DateTime($requestData['finished_at']);
        }

        return (new ProductPackageCreateDTO())
            ->setTitle($requestData['title'] ?? null)
            ->setAmount($requestData['amount'] ?? null)
            ->setFinishedAt($finishedAt)
            ->setType($requestData['type'] ?? null)
            ->setHash(md5(json_encode($requestData)));
    }
}
