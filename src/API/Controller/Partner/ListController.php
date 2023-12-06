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
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    public function __construct(
        private PartnerService $partnerService,
        private ArrayTransformerInterface $serializer
    ) {
    }

    /**
     * Получить список ТСП
     */
    #[Route('/api/catalog/partner/list', methods: ['GET'])]
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
    #[Attributes\Tag(name: 'Partner')]
    public function getList(): JsonResponse
    {
        return new JsonResponse([
            'data' => $this->serializer->toArray(
                $this->partnerService->getList(),
                (new SerializationContext())->setSerializeNull(true)
            ),
        ]);
    }
}
