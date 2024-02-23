<?php

namespace App\Entity;

use App\Repository\CertificateRepository;
use App\Service\CertificateService\Constants\CertificateConstants;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: CertificateRepository::class)]
#[ORM\Table(name: 'certificate', options: ['comment' => 'Справочник Сертификаты'])]
#[ORM\Index(columns: ['product_package_id'], name: 'certificate_product_package_idx')]
#[ORM\Index(columns: ['client_order_id'], name: 'certificate_client_order_idx')]
#[ORM\Index(columns: ['status'], name: 'certificate_status_idx')]
class Certificate
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'certificates')]
    private Order $clientOrder;

    #[ORM\ManyToOne(targetEntity: ProductPackage::class, inversedBy: 'certificates')]
    private ProductPackage $productPackage;
//    #[ORM\Column(nullable: false)]
//    private int $client_order_id;
//    #[ORM\Column(nullable: false)]
//    private int $product_package_id;

    #[ORM\Column(type: Types::STRING, length: 60, nullable: true)]
    private ?string $hash = null;

    #[ORM\Column(nullable: true)]
    private ?int $amount = null;

    #[ORM\Column(type: Types::INTEGER, length: 2, nullable: false, options: ['default' => CertificateConstants::STATUS_NEW, 'comment' => 'Статус Сертификата'])]
    private ?int $status = CertificateConstants::STATUS_NEW;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $card_number = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $payment_system = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientOrder(): Order
    {
        return $this->clientOrder;
    }

    public function setClientOrder(Order $clientOrder): self
    {
        $this->clientOrder = $clientOrder;

        return $this;
    }

    public function getProductPackage(): ProductPackage
    {
        return $this->productPackage;
    }

    public function setProductPackage(ProductPackage $package): self
    {
        $this->productPackage = $package;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(?string $hash): static
    {
        $this->hash = $hash;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(?int $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCardNumber(): ?string
    {
        return $this->card_number;
    }

    public function setCardNumber(?string $card_number): static
    {
        $this->card_number = $card_number;

        return $this;
    }

    public function getPaymentSystem(): ?string
    {
        return $this->payment_system;
    }

    public function setPaymentSystem(?string $payment_system): static
    {
        $this->payment_system = $payment_system;

        return $this;
    }
}
