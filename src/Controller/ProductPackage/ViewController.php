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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ViewController extends AbstractController
{
    public function __construct(
        private ProductPackageActionComponent $actionComponent,
        private ArrayTransformerInterface $serializer
    ) {
    }

    /**
     * Получить подробные данные по пакету услуг.
     */
    #[Route('/api/catalog/product/package', methods: ['GET'])]
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
    #[Attributes\Parameter(
        name: 'identifier',
        description: 'Идентификатор услуги',
        in: 'query',
        required: true,
        schema: new Attributes\Schema(type: 'integer')
    )]
    #[Attributes\Tag(name: 'Product package')]
    public function view(Request $request): JsonResponse
    {
        $identifier = $request->get('identifier');
        if (null === $identifier) {
            throw new BadRequestHttpException('Param `identifier` is required');
        }

        $response = null;
        $statusCode = 404;
        $package = $this->actionComponent->view((int) trim($identifier));
        if (null !== $package) {
            $response = $this->serializer->toArray(
                $package,
                (new SerializationContext())->setSerializeNull(true)
            );
            $statusCode = 200;
        }

        return (new JsonResponse())
            ->setStatusCode($statusCode)
            ->setData([
                'data' => $response,
            ]);
    }
}
