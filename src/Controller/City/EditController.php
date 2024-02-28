<?php

declare(strict_types=1);

namespace App\Controller\City;

use App\DTO\Builder\CertificateEditDTOBuilder;
use App\DTO\Builder\CityEditDTOBuilder;
use App\DTO\Builder\OrderEditDTOBuilder;
use App\DTO\Builder\PartnerEditDTOBuilder;
use App\DTO\Builder\RegionEditDTOBuilder;
use App\DTO\Request\CertificateEditDTO;
use App\DTO\Request\CityEditDTO;
use App\DTO\Request\OrderEditDTO;
use App\DTO\Request\PartnerEditDTO;
use App\DTO\Request\RegionEditDTO;
use App\Service\CertificateService\Component\CertificateActionComponent;
use App\Service\CertificateService\DTO\CertificateDTO;
use App\Service\GeoService\Component\CityActionComponent;
use App\Service\GeoService\Component\RegionActionComponent;
use App\Service\GeoService\DTO\CityDTO;
use App\Service\GeoService\DTO\RegionDTO;
use App\Service\OrderService\Component\OrderActionComponent;
use App\Service\OrderService\DTO\OrderDTO;
use App\Service\PartnerService\Component\PartnerActionComponent;
use App\Service\PartnerService\DTO\PartnerDTO;
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
        private CityActionComponent $actionComponent,
        private ArrayTransformerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
    }

    /**
     * Отредактировать город
     */
    #[Route('/api/catalog/city', methods: ['PUT'])]
    #[Attributes\Response(
        response: 200,
        description: 'Success',
        content: new Attributes\JsonContent(
            ref: new Model(type: CityDTO::class)
        )
    )]
    #[Attributes\Parameter(
        name: 'identifier',
        description: 'Идентификатор города',
        in: 'query',
        required: true,
        schema: new Attributes\Schema(type: 'integer')
    )]
    #[Attributes\RequestBody(
        required: true,
        content: new Attributes\JsonContent(
            ref: new Model(type: CityEditDTO::class)
        )
    )]
    #[Attributes\Tag(name: 'City')]
    public function create(Request $request): JsonResponse
    {
        $requestDTO = CityEditDTOBuilder::build(
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
