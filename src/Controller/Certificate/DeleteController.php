<?php

declare(strict_types=1);

namespace App\Controller\Certificate;

use App\Service\CertificateService\Component\CertificateActionComponent;
use App\Service\OrderService\Component\OrderActionComponent;
use App\Service\PartnerService\Component\PartnerActionComponent;
use OpenApi\Attributes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    public function __construct(
        private CertificateActionComponent $actionComponent,
    ) {
    }

    /**
     * Удалить Сертификат из справочника.
     * Сертификат получает status = STATUS_REMOVED.
     */
    #[Route('/api/catalog/certificate', methods: ['DELETE'])]
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
    #[Attributes\Tag(name: 'Certificate')]
    public function delete(Request $request): JsonResponse
    {
        $identifier = $request->get('identifier');
        if (null === $identifier) {
            throw new BadRequestHttpException('Param `identifier` is required');
        }

        return new JsonResponse([
            'success' => $this->actionComponent->deleteItem((int) trim($identifier)),
        ]);
    }
}
