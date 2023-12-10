<?php

declare(strict_types=1);

namespace App\Controller\ProductPackage;

use App\Service\ProductService\Component\ProductPackageActionComponent;
use App\Service\ProductService\ProductService;
use OpenApi\Attributes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    public function __construct(
        private ProductPackageActionComponent $actionComponent,
        private ProductService $productService,
    ) {
    }

    /**
     * Удалить пакет услуг из справочника.
     * Услуга получает status = STATUS_REMOVED.
     */
    #[Route('/api/catalog/product/package', methods: ['DELETE'])]
    #[Attributes\Response(
        response: 200,
        description: 'Success',
    )]
    #[Attributes\Parameter(
        name: 'identifier',
        description: 'Идентификатор пакета услуг',
        in: 'query',
        required: true,
        schema: new Attributes\Schema(type: 'integer')
    )]
    #[Attributes\Tag(name: 'Product package')]
    public function delete(Request $request): JsonResponse
    {
        $identifier = $request->get('identifier');
        if (null === $identifier) {
            throw new BadRequestHttpException('Param `identifier` is required');
        }

        $notRemovedProductsInPackage = count(
            $this->productService->findNotRemoveProductsByPackageBy((int) $identifier)
        );

        $errors = [];
        if ($notRemovedProductsInPackage > 0) {
            $success = false;
            $errors[] = "Package #$identifier has active products";
        } else {
            $success = $this->actionComponent->deleteItem((int) trim($identifier));
        }

        return new JsonResponse([
            'success' => $success,
            'errors' => $errors,
        ]);
    }
}
