<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use App\Service\OrderService\Constants\OrderConstants;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: 'client_order', options: ['comment' => 'Справочник Заказов'])]
#[ORM\Index(columns: ['status'], name: 'order_status_idx')]
class Order
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private ?int $id = null;

    #[ORM\Column(type: Types::INTEGER, length: 2, nullable: false, options: ['default' => OrderConstants::STATUS_NEW, 'comment' => 'Статус заказа'])]
    private ?int $status = OrderConstants::STATUS_NEW;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

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
