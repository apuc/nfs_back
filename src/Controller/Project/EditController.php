<?php

declare(strict_types=1);

namespace App\Controller\Project;

use App\DTO\Builder\OrderEditDTOBuilder;
use App\DTO\Builder\PartnerEditDTOBuilder;
use App\DTO\Builder\ProjectEditDTOBuilder;
use App\DTO\Request\OrderEditDTO;
use App\DTO\Request\PartnerEditDTO;
use App\DTO\Request\ProjectEditDTO;
use App\Service\OrderService\Component\OrderActionComponent;
use App\Service\OrderService\DTO\OrderDTO;
use App\Service\PartnerService\Component\PartnerActionComponent;
use App\Service\PartnerService\DTO\PartnerDTO;
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

class EditController extends AbstractController
{
    public function __construct(
        private ProjectActionComponent $actionComponent,
        private ArrayTransformerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
    }

    /**
     * Отредактировать проект
     */
    #[Route('/api/catalog/project', methods: ['PUT'])]
    #[Attributes\Response(
        response: 200,
        description: 'Success',
        content: new Attributes\JsonContent(
            ref: new Model(type: ProjectDTO::class)
        )
    )]
    #[Attributes\Parameter(
        name: 'identifier',
        description: 'Идентификатор проекта',
        in: 'query',
        required: true,
        schema: new Attributes\Schema(type: 'integer')
    )]
    #[Attributes\RequestBody(
        required: true,
        content: new Attributes\JsonContent(
            ref: new Model(type: ProjectEditDTO::class)
        )
    )]
    #[Attributes\Tag(name: 'Project')]
    public function create(Request $request): JsonResponse
    {
        $requestDTO = ProjectEditDTOBuilder::build(
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
