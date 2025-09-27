<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_dashboard_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }
}
