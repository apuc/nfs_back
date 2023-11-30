<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/catalog', name: 'catalog', methods: ['GET'])]
class CatalogController extends AbstractController
{
    #[Route('/partners', name: '_partners_list', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('catalog/partners/list.html.twig', ['page_title' => 'Справочники - ТСП']);
    }
}
