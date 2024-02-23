<?php

declare(strict_types=1);

namespace App\Service\OrderService\Component;

use App\DTO\Request\OrderCreateDTO;
use App\DTO\Request\OrderEditDTO;
use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Service\OrderService\Builder\OrderDTOBuilder;
use App\Service\OrderService\Constants\OrderConstants;
use App\Service\OrderService\DTO\OrderDTO;
use App\Service\OrderService\OrderService;
use Psr\Log\LoggerInterface;

class OrderActionComponent
{
    public function __construct(
        private OrderRepository $repository,
        private OrderService $service,
        private LoggerInterface $orderLogger,
    ) {
    }

    public function createNew(OrderCreateDTO $createDTO): OrderDTO
    {
        $order = (new Order())
            ->setStatus(OrderConstants::STATUS_NEW);

        $this->repository->save($order);

        return OrderDTOBuilder::build($order);
    }

    public function view(int $identifier): ?OrderDTO
    {
        return OrderDTOBuilder::build(
            $this->repository->findOneBy(['id' => $identifier])
        );
    }

    public function getList(): array
    {
        $result = [];
        foreach ($this->repository->findAllNotRemoved() as $order) {
            $result[] = OrderDTOBuilder::build($order);
        }

        return $result;
    }

    public function edit(OrderEditDTO $editDTO): OrderDTO
    {
        $order = $this->repository->findById($editDTO->getId());

        if (null !== $order) {
            $order->setStatus($editDTO->getStatus() ?? $order->getStatus());

            $this->repository->save($order);
        }

        return OrderDTOBuilder::build($order);
    }

    public function deleteItem(int $identifier): bool
    {
        try {
            $partner = $this->repository->findOneBy(['id' => $identifier]);
            if (null !== $partner) {
                $partner->setStatus(OrderConstants::STATUS_REMOVED);

                $this->repository->save($partner);
            }

            return true;
        } catch (\Throwable $exception) {
            $this->orderLogger->critical(
                'Error when partner remove: '.$exception->getMessage(),
                [
                    'identifier' => $identifier,
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                ]
            );

            return false;
        }
    }
}
