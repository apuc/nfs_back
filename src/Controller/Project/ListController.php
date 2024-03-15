<?php

declare(strict_types=1);

namespace App\Controller\Project;

use App\Service\ProjectService\Component\ProjectActionComponent;
use App\Service\ProjectService\DTO\ProjectDTO;
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
        private ProjectActionComponent $actionComponent,
        private ArrayTransformerInterface $serializer
    ) {
    }

    /**
     * Получить список проектов.
     */
    #[Route('/api/catalog/project/list', methods: ['GET'])]
    #[Attributes\Response(
        response: 200,
        description: 'Success',
        content: new Attributes\JsonContent(
            type: 'array',
            items: new Attributes\Items(
                ref: new Model(type: ProjectDTO::class)
            )
        )
    )]
    #[Attributes\Tag(name: 'Project')]
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
