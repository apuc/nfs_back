<?php

declare(strict_types=1);

namespace App\Controller\Product;

use App\Service\ProductService\DTO\ProductDTO;
use App\Service\ProductService\ProductService;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializationContext;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ViewController extends AbstractController
{
    public function __construct(
        private ProductService $productService,
        private ArrayTransformerInterface $serializer
    ) {
    }

    /**
     * Получить подробные данные по услуге
     */
    #[Route('/api/catalog/product', methods: ['GET'])]
    #[Attributes\Response(
        response: 200,
        description: 'Success',
        content: new Attributes\JsonContent(
            type: 'array',
            items: new Attributes\Items(
                ref: new Model(type: ProductDTO::class)
            )
        )
    )]
    #[Attributes\Parameter(
        name: 'identifier',
        description: 'Идентификатор',
        in: 'query',
        required: true,
        schema: new Attributes\Schema(type: 'integer')
    )]
    #[Attributes\Tag(name: 'Product')]
    public function view(Request $request): JsonResponse
    {
        $identifier = $request->get('identifier');
        if (null === $identifier) {
            throw new BadRequestHttpException('Param `identifier` is required');
        }

        return new JsonResponse([
            'data' => $this->serializer->toArray(
                $this->productService->view((int) trim($identifier)),
                (new SerializationContext())->setSerializeNull(true)
            ),
        ]);
    }
}
