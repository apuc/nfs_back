<?php

declare(strict_types=1);

namespace App\Controller\Partner;

use App\DTO\Builder\PartnerCreateDTOBuilder;
use App\DTO\Request\PartnerCreateDTO;
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
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateController extends AbstractController
{
    public function __construct(
        private PartnerService $partnerService,
        private ArrayTransformerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
    }

    /**
     * Создать новое ТСП
     */
    #[Route('/api/catalog/partner', methods: ['PUT'])]
    #[Attributes\Response(
        response: 200,
        description: 'Success',
        content: new Attributes\JsonContent(
            ref: new Model(type: PartnerDTO::class)
        )
    )]
    #[Attributes\Response(
        response: 400,
        description: 'Во входных данных есть ошибки',
    )]
    #[Attributes\RequestBody(
        required: true,
        content: new Attributes\JsonContent(
            ref: new Model(type: PartnerCreateDTO::class)
        )
    )]
    #[Attributes\Tag(name: 'Partner')]
    public function create(Request $request): JsonResponse
    {
        $requestDTO = PartnerCreateDTOBuilder::build(
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
                    $this->partnerService->createNew($requestDTO),
                    (new SerializationContext())->setSerializeNull(true)
                ),
                'errors' => null,
            ]);
    }
}
