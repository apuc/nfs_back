<?php

declare(strict_types=1);

namespace App\Service\PartnerService\Controller;

use App\Base\Constants\MenuConstants;
use App\Service\ContextService\ContextService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/catalog', name: 'catalog', methods: ['GET'])]
class Controller extends AbstractController
{
    public function __construct(
        private ContextService $contextService
    ) {
    }

    #[Route('/partners', name: '_partners_list', methods: ['GET'])]
    public function index(): Response
    {
        $this->contextService
            ->setActiveMenuItemAlias(MenuConstants::CATALOG_MENU_PARTNERS_ITEM);

        return $this->render('catalog/partners/list.html.twig');
    }
}
