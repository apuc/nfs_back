<?php

declare(strict_types=1);

namespace App\Controller;

use App\Base\Constants\MenuConstants;
use App\Service\ContextService\ContextService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    public function __construct(
        private ContextService $contextService
    ) {
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $this->contextService
            ->setActiveMenuItemAlias(MenuConstants::INDEX_MENU_ITEM);

        return $this->render('index.html.twig');
    }
}
