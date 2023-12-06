<?php

declare(strict_types=1);

namespace App\API\Controller\Partner;

use API\DTO\Builder\PartnerRequestDTOBuilder;
use App\Service\PartnerService\DTO\PartnerDTO;
use App\Service\PartnerService\PartnerService;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializationContext;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController
{
    public function __construct(
        private PartnerService $partnerService,
        private ArrayTransformerInterface $serializer
    ) {
    }

    /**
     * Отредактировать ТСП
     */
    #[Route('/api/catalog/partner', methods: ['POST'])]
    #[Attributes\Response(
        response: 200,
        description: 'Success',
        content: new Attributes\JsonContent(
            ref: new Model(type: PartnerDTO::class)
        )
    )]
    #[Attributes\Tag(name: 'Partner')]
    public function create(Request $request): JsonResponse
    {
        return new JsonResponse([
            'data' => $this->serializer->toArray(
                $this->partnerService->edit(
                    PartnerRequestDTOBuilder::build($request)
                ),
                (new SerializationContext())->setSerializeNull(true)
            ),
        ]);
    }
}
