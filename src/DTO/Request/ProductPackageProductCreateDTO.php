<?php

declare(strict_types=1);

namespace App\DTO\Request;

use App\Service\Validator\Constraints as AcmeAssert;
use Doctrine\DBAL\Types\Types;
use OpenApi\Attributes;

class ProductPackageProductCreateDTO
{
    #[Attributes\Property(
        description: 'Идентификатор продукта',
        type: Types::INTEGER,
    )]
    #[AcmeAssert\NotEmpty]
    private ?int $product_id;

    #[Attributes\Property(
        description: 'Идентификатор пакета продуктов',
        type: Types::INTEGER,
    )]
    #[AcmeAssert\NotEmpty]
    private ?int $product_package_id;

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->product_id;
    }

    /**
     * @param int|null $product_id
     *
     * @return ProductPackageProductCreateDTO
     */
    public function setProductId(?int $product_id): self
    {
        $this->product_id = $product_id;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getProductPackageId(): ?int
    {
        return $this->product_package_id;
    }

    /**
     * @param int|null $product_package_id
     *
     * @return ProductPackageProductCreateDTO
     */
    public function setProductPackageId(?int $product_package_id): self
    {
        $this->product_package_id = $product_package_id;

        return $this;
    }
}
