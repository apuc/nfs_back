<?php

declare(strict_types=1);

namespace App\Controller\Project;

use App\DTO\Builder\OrderCreateDTOBuilder;
use App\DTO\Builder\ProjectCreateDTOBuilder;
use App\DTO\Request\OrderCreateDTO;
use App\DTO\Request\ProjectCreateDTO;
use App\Service\OrderService\Component\OrderActionComponent;
use App\Service\OrderService\DTO\OrderDTO;
use App\Service\ProjectService\Component\ProjectActionComponent;
use App\Service\ProjectService\DTO\ProjectDTO;
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
        private ProjectActionComponent $actionComponent,
        private ArrayTransformerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
    }

    /**
     * Создать новый Проект
     */
    #[Route('/api/catalog/project', methods: ['POST'])]
    #[Attributes\Response(
        response: 200,
        description: 'Success',
        content: new Attributes\JsonContent(
            ref: new Model(type: ProjectDTO::class)
        )
    )]
    #[Attributes\Response(
        response: 400,
        description: 'Во входных данных есть ошибки',
    )]
    #[Attributes\RequestBody(
        required: true,
        content: new Attributes\JsonContent(
            ref: new Model(type: ProjectCreateDTO::class)
        )
    )]
    #[Attributes\Tag(name: 'Project')]
    public function create(Request $request): JsonResponse
    {
        $requestDTO = ProjectCreateDTOBuilder::build(
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
