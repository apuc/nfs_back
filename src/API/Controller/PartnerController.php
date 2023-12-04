<?php

declare(strict_types=1);

namespace App\API\Controller;

use App\Service\PartnerService\PartnerDTO;
use App\Service\PartnerService\PartnerService;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializationContext;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[
    Route('/api/partner', name: 'api_partner')]
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
#[Attributes\Tag(name: 'Catalog')]
class PartnerController extends AbstractController
{
    public function __construct(
        private PartnerService $partnerService,
        private ArrayTransformerInterface $serializer,
    ) {
    }

    /**
     * Получить список событий.
     */
    #[Route('/list', name: '_list', methods: ['GET'])]
    public function getList(): Response
    {
        $partnersList = $this->serializer->toArray(
            $this->partnerService->getList(),
            (new SerializationContext())->setSerializeNull(true)
        );

        return new JsonResponse($partnersList);
    }
}
