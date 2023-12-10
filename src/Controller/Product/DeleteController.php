<?php

declare(strict_types=1);

namespace App\Controller\Product;

use App\Service\PartnerService\DTO\PartnerDTO;
use App\Service\PartnerService\PartnerService;
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

class DeleteController extends AbstractController
{
    public function __construct(
        private ProductService $productService,
        private ArrayTransformerInterface $serializer
    ) {
    }

    /**
     * Удалить услугу из справочника.
     * Услуга получает status = STATUS_REMOVED.
     */
    #[Route('/api/catalog/product', methods: ['DELETE'])]
    #[Attributes\Response(
        response: 200,
        description: 'Success',
        content: new Attributes\JsonContent(
            ref: new Model(type: PartnerDTO::class)
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
    public function delete(Request $request): JsonResponse
    {
        $identifier = $request->get('identifier');
        if (null === $identifier) {
            throw new BadRequestHttpException('Param `identifier` is required');
        }

        return new JsonResponse([
            'success' => $this->productService->deleteItem((int) trim($identifier)),
        ]);
    }
}
