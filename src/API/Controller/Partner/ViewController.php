<?php

declare(strict_types=1);

namespace App\API\Controller\Partner;

use App\Service\PartnerService\DTO\PartnerDTO;
use App\Service\PartnerService\PartnerService;
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
        private PartnerService $partnerService,
        private ArrayTransformerInterface $serializer
    ) {
    }

    /**
     * Получить подробные данные по ТСП
     */
    #[Route('/api/catalog/partner', methods: ['GET'])]
    #[Attributes\Response(
        response: 200,
        description: 'Success',
        content: new Attributes\JsonContent(
            type: 'array',
            items: new Attributes\Items(
                ref: new Model(type: PartnerDTO::class)
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
    #[Attributes\Tag(name: 'Partner')]
    public function view(Request $request): JsonResponse
    {
        $identifier = $request->get('identifier');
        if (null === $identifier) {
            throw new BadRequestHttpException('Param `identifier` is required');
        }

        return new JsonResponse([
            'data' => $this->serializer->toArray(
                $this->partnerService->view((int) trim($identifier)),
                (new SerializationContext())->setSerializeNull(true)
            ),
        ]);
    }
}
