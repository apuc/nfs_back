<?php

declare(strict_types=1);

namespace App\Controller\Terminal;

use App\Service\TerminalService\Component\TerminalActionComponent;
use App\Service\TerminalService\DTO\TerminalDTO;
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
        private TerminalActionComponent $actionComponent,
        private ArrayTransformerInterface $serializer
    ) {
    }

    /**
     * Получить список терминалов.
     */
    #[Route('/api/catalog/terminal/list', methods: ['GET'])]
    #[Attributes\Response(
        response: 200,
        description: 'Success',
        content: new Attributes\JsonContent(
            type: 'array',
            items: new Attributes\Items(
                ref: new Model(type: TerminalDTO::class)
            )
        )
    )]
    #[Attributes\Tag(name: 'Terminal')]
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
