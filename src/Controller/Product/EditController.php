<?php

declare(strict_types=1);

namespace App\Controller\Product;

use App\DTO\Builder\ProductEditDTOBuilder;
use App\DTO\Request\ProductEditDTO;
use App\Service\ProductService\Component\ProductActionComponent;
use App\Service\ProductService\DTO\ProductDTO;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializationContext;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EditController extends AbstractController
{
    public function __construct(
        private ProductActionComponent $actionComponent,
        private ArrayTransformerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
    }

    /**
     * Отредактировать услугу.
     */
    #[Route('/api/catalog/product', methods: ['POST'])]
    #[Attributes\Response(
        response: 200,
        description: 'Success',
        content: new Attributes\JsonContent(
            ref: new Model(type: ProductDTO::class)
        )
    )]
    #[Attributes\Parameter(
        name: 'identifier',
        description: 'Идентификатор услуги',
        in: 'query',
        required: true,
        schema: new Attributes\Schema(type: 'integer')
    )]
    #[Attributes\RequestBody(
        required: true,
        content: new Attributes\JsonContent(
            ref: new Model(type: ProductEditDTO::class)
        )
    )]
    #[Attributes\Tag(name: 'Product')]
    public function create(Request $request): JsonResponse
    {
        $requestDTO = ProductEditDTOBuilder::build(
            (int) $request->get('identifier'),
            json_decode($request->getContent(), true)
        );

        $response = new JsonResponse();
        $errorsArr = [];
        foreach ($this->validator->validate($requestDTO) as $error) {
            $errorsArr[] = $error->getMessage();
        }

        if (!empty($errorsArr)) {
            return $response
                ->setStatusCode(400)
                ->setData([
                    'data' => null,
                    'errors' => $errorsArr,
                ]);
        }

        return $response
            ->setStatusCode(200)
            ->setData([
                'data' => $this->serializer->toArray(
                    $this->actionComponent->edit($requestDTO),
                    (new SerializationContext())->setSerializeNull(true)
                ),
                'errors' => null,
            ]);
    }
}
