<?php

declare(strict_types=1);

namespace App\Controller\Region;

use App\Repository\PartnerTerminalRepository;
use App\Repository\RegionRepository;
use OpenApi\Attributes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    public function __construct(
        private RegionRepository $repository,
    ) {
    }

    /**
     * Удалить Регион из справочника.
     */
    #[Route('/api/catalog/region', methods: ['DELETE'])]
    #[Attributes\Response(
        response: 200,
        description: 'Success',
    )]
    #[Attributes\Parameter(
        name: 'identifier',
        description: 'Идентификатор',
        in: 'query',
        required: true,
        schema: new Attributes\Schema(type: 'integer')
    )]
    #[Attributes\Tag(name: 'Region')]
    public function delete(Request $request): JsonResponse
    {
        $identifier = $request->get('identifier');
        if (null === $identifier) {
            throw new BadRequestHttpException('Param `identifier` is required');
        }

        $region = $this->repository->findById((int) $identifier);
        if (null === $region) {
            throw new BadRequestHttpException('Region not found');
        }

        $this->repository->remove($region);

        return new JsonResponse([
            'success' => 'The record has been deleted',
        ]);
    }
}
