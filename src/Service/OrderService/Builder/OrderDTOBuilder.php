<?php

namespace App\Service\OrderService\Builder;

use App\Entity\Order;
use App\Service\OrderService\DTO\OrderDTO;

class OrderDTOBuilder
{
    public static function build(Order $order): ?OrderDTO
    {
        if (null === $order) {
            return null;
        }

        return (new OrderDTO())
            ->setId($order->getId())
            ->setStatus($order->getStatus())
            ->setCreatedAt(\DateTimeImmutable::createFromMutable($order->getCreatedAt()))
            ->setUpdatedAt(\DateTimeImmutable::createFromMutable($order->getUpdatedAt()));
    }
}
