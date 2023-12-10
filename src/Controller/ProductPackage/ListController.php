<?php

declare(strict_types=1);

namespace App\Controller\ProductPackage;

use App\Service\ProductService\Component\ProductPackageActionComponent;
use App\Service\ProductService\DTO\ProductPackageDTO;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializationContext;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    public function __construct(
        private ProductPackageActionComponent $actionComponent,
        private ArrayTransformerInterface $serializer
    ) {
    }

    /**
     * Получить список пакетов услуг.
     */
    #[Route('/api/catalog/product/package/list', methods: ['GET'])]
    #[Attributes\Response(
        response: 200,
        description: 'Success',
        content: new Attributes\JsonContent(
            type: 'array',
            items: new Attributes\Items(
                ref: new Model(type: ProductPackageDTO::class)
            )
        )
    )]
    #[Attributes\Tag(name: 'Product package')]
    public function getList(): JsonResponse
    {
        return new JsonResponse([
            'data' => $this->serializer->toArray(
                $this->actionComponent->getList(),
                (new SerializationContext())->setSerializeNull(true)
            ),
        ]);
    }
}
