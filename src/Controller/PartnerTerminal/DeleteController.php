<?php

declare(strict_types=1);

namespace App\Controller\PartnerTerminal;

use App\Repository\PartnerTerminalRepository;
use OpenApi\Attributes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    public function __construct(
        private PartnerTerminalRepository $terminalRepository,
    ) {
    }

    /**
     * Удалить Терминал / ТСП из справочника.
     */
    #[Route('/api/catalog/partner-terminal', methods: ['DELETE'])]
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
    #[Attributes\Tag(name: 'PartnerTerminal')]
    public function delete(Request $request): JsonResponse
    {
        $identifier = $request->get('identifier');
        if (null === $identifier) {
            throw new BadRequestHttpException('Param `identifier` is required');
        }

        $partnerTerminal = $this->terminalRepository->findById((int) $identifier);
        if (null === $partnerTerminal) {
            throw new BadRequestHttpException('PartnerTerminal not found');
        }

        $this->terminalRepository->remove($partnerTerminal);

        return new JsonResponse([
            'success' => 'The record has been deleted',
        ]);
    }
}
