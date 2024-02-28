<?php

declare(strict_types=1);

namespace App\Controller\City;

use App\DTO\Builder\CityCreateDTOBuilder;
use App\DTO\Builder\RegionCreateDTOBuilder;
use App\DTO\Request\CityCreateDTO;
use App\DTO\Request\RegionCreateDTO;
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
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateController extends AbstractController
{
    public function __construct(
        private CityActionComponent $actionComponent,
        private ArrayTransformerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
    }

    /**
     * Создать новый город.
     */
    #[Route('/api/catalog/city', methods: ['POST'])]
    #[Attributes\Response(
        response: 200,
        description: 'Success',
        content: new Attributes\JsonContent(
            ref: new Model(type: CityDTO::class)
        )
    )]
    #[Attributes\Response(
        response: 400,
        description: 'Во входных данных есть ошибки',
    )]
    #[Attributes\RequestBody(
        required: true,
        content: new Attributes\JsonContent(
            ref: new Model(type: CityCreateDTO::class)
        )
    )]
    #[Attributes\Tag(name: 'City')]
    public function create(Request $request): JsonResponse
    {
        $requestDTO = CityCreateDTOBuilder::build(
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
                    $this->actionComponent->createNew($requestDTO),
                    (new SerializationContext())->setSerializeNull(true)
                ),
                'errors' => null,
            ]);
    }
}
