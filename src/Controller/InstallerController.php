<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\AppSettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class InstallerController extends AbstractController
{
    private AppSettingRepository $appSettingRepository;

    public function __construct(AppSettingRepository $appSettingRepository)
    {
        $this->appSettingRepository = $appSettingRepository;
    }

    #[Route('/installer')]
    public function index(): Response
    {
        $appSettings = $this->appSettingRepository->findOneBy(['name' => 'installed']);
        if ($appSettings->getValue() === "1") {
            return $this->redirectToRoute('app_index');
        }
        return $this->render('installer/index.html.twig');
    }
}
