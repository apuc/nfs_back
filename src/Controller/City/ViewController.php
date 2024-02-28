<?php

declare(strict_types=1);

namespace App\Controller\City;

use App\Service\GeoService\Component\CityActionComponent;
use App\Service\GeoService\Component\RegionActionComponent;
use App\Service\GeoService\DTO\CityDTO;
use App\Service\GeoService\DTO\RegionDTO;
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
        private CityActionComponent $actionComponent,
        private ArrayTransformerInterface $serializer
    ) {
    }

    /**
     * Получить подробные данные по городу.
     */
    #[Route('/api/catalog/city', methods: ['GET'])]
    #[Attributes\Response(
        response: 200,
        description: 'Success',
        content: new Attributes\JsonContent(
            type: 'array',
            items: new Attributes\Items(
                ref: new Model(type: CityDTO::class)
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
    #[Attributes\Tag(name: 'City')]
    public function view(Request $request): JsonResponse
    {
        $identifier = $request->get('identifier');
        if (null === $identifier) {
            throw new BadRequestHttpException('Param `identifier` is required');
        }

        $response = null;
        $statusCode = 404;
        $partner = $this->actionComponent->view((int) trim($identifier));
        if (null !== $partner) {
            $response = $this->serializer->toArray(
                $partner,
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
