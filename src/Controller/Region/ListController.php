<?php

declare(strict_types=1);

namespace App\Controller\Region;

use App\Service\GeoService\Component\RegionActionComponent;
use App\Service\GeoService\DTO\RegionDTO;
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
        private RegionActionComponent $actionComponent,
        private ArrayTransformerInterface $serializer
    ) {
    }

    /**
     * Получить список Регионов.
     */
    #[Route('/api/catalog/region/list', methods: ['GET'])]
    #[Attributes\Response(
        response: 200,
        description: 'Success',
        content: new Attributes\JsonContent(
            type: 'array',
            items: new Attributes\Items(
                ref: new Model(type: RegionDTO::class)
            )
        )
    )]
    #[Attributes\Tag(name: 'Region')]
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
