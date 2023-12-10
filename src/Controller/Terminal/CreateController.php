<?php

declare(strict_types=1);

namespace App\Controller\Terminal;

use App\DTO\Builder\TerminalCreateDTOBuilder;
use App\DTO\Request\TerminalCreateDTO;
use App\Service\TerminalService\Component\TerminalActionComponent;
use App\Service\TerminalService\DTO\TerminalDTO;
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
        private TerminalActionComponent $actionComponent,
        private ArrayTransformerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
    }

    /**
     * Создать новый терминал.
     */
    #[Route('/api/catalog/terminal', methods: ['PUT'])]
    #[Attributes\Response(
        response: 200,
        description: 'Success',
        content: new Attributes\JsonContent(
            ref: new Model(type: TerminalDTO::class)
        )
    )]
    #[Attributes\Response(
        response: 400,
        description: 'Во входных данных есть ошибки',
    )]
    #[Attributes\RequestBody(
        required: true,
        content: new Attributes\JsonContent(
            ref: new Model(type: TerminalCreateDTO::class)
        )
    )]
    #[Attributes\Tag(name: 'Terminal')]
    public function create(Request $request): JsonResponse
    {
        $requestDTO = TerminalCreateDTOBuilder::build(
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
                    $this->actionComponent->create($requestDTO),
                    (new SerializationContext())->setSerializeNull(true)
                ),
                'errors' => null,
            ]);
    }
}
