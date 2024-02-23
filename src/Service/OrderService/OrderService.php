<?php

declare(strict_types=1);

namespace App\Service\OrderService;

use App\Entity\Order;
use App\Repository\OrderRepository;

class OrderService
{
    public function __construct(private OrderRepository $repository)
    {
    }

    public function findEntityById(int $identifier): ?Order
    {
        return $this->repository->findOneBy(['id' => $identifier]);
    }
}
