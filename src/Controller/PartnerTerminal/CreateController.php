<?php

declare(strict_types=1);

namespace App\Controller\PartnerTerminal;

use App\DTO\Builder\PartnerCreateDTOBuilder;
use App\DTO\Builder\PartnerTerminalCreateDTOBuilder;
use App\DTO\Request\PartnerTerminalCreateDTO;
use App\Service\PartnerTerminalService\Component\PartnerTerminalActionComponent;
use App\Service\TerminalService\DTO\PartnerTerminalDTO;
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
        private PartnerTerminalActionComponent $actionComponent,
        private ArrayTransformerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
    }

    /**
     * Создать новое Терминал / ТСП
     */
    #[Route('/api/catalog/partner-terminal', methods: ['POST'])]
    #[Attributes\Response(
        response: 200,
        description: 'Success',
        content: new Attributes\JsonContent(
            ref: new Model(type: PartnerTerminalDTO::class)
        )
    )]
    #[Attributes\Response(
        response: 400,
        description: 'Во входных данных есть ошибки',
    )]
    #[Attributes\RequestBody(
        required: true,
        content: new Attributes\JsonContent(
            ref: new Model(type: PartnerTerminalCreateDTO::class)
        )
    )]
    #[Attributes\Tag(name: 'PartnerTerminal')]
    public function create(Request $request): JsonResponse
    {
        $requestDTO = PartnerTerminalCreateDTOBuilder::build(
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
