<?php

declare(strict_types=1);

namespace App\Controller\PartnerTerminal;

use App\DTO\Builder\PartnerEditDTOBuilder;
use App\DTO\Builder\PartnerTerminalEditDTOBuilder;
use App\DTO\Request\PartnerEditDTO;
use App\DTO\Request\PartnerTerminalEditDTO;
use App\Service\PartnerService\Component\PartnerActionComponent;
use App\Service\PartnerService\DTO\PartnerDTO;
use App\Service\PartnerTerminalService\Component\PartnerTerminalActionComponent;
use App\Service\PartnerTerminalService\PartnerTerminalDTO;
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
        private PartnerTerminalActionComponent $actionComponent,
        private ArrayTransformerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
    }

    /**
     * Отредактировать ТСП
     */
    #[Route('/api/catalog/partner-terminal', methods: ['PUT'])]
    #[Attributes\Response(
        response: 200,
        description: 'Success',
        content: new Attributes\JsonContent(
            ref: new Model(type: PartnerTerminalDTO::class)
        )
    )]
    #[Attributes\Parameter(
        name: 'identifier',
        description: 'Идентификатор ТСП',
        in: 'query',
        required: true,
        schema: new Attributes\Schema(type: 'integer')
    )]
    #[Attributes\RequestBody(
        required: true,
        content: new Attributes\JsonContent(
            ref: new Model(type: PartnerTerminalEditDTO::class)
        )
    )]
    #[Attributes\Tag(name: 'PartnerTerminal')]
    public function create(Request $request): JsonResponse
    {
        $requestDTO = PartnerTerminalEditDTOBuilder::build(
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
