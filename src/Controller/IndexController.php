<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\InfoCard;
use App\Repository\AppSettingRepository;
use App\Repository\InfoCardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    private InfoCardRepository $infoCardRepository;
    private AppSettingRepository $appSettingRepository;

    public function __construct(AppSettingRepository $appSettingRepository, InfoCardRepository $infoCardRepository)
    {
        $this->infoCardRepository = $infoCardRepository;
        $this->appSettingRepository = $appSettingRepository;
    }


    //#[Route('/home/{_locale}', name: 'app_index_es')]
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        $appSettings = $this->appSettingRepository->findAll();
        $installed = $appSettings[0];
        if ($installed->getValue()==="0") {
            return $this->redirectToRoute('app_installer_index');
        }
        $bg = $appSettings[1];
        $title = $appSettings[2];
        $blogEnabled = $appSettings[3];

        //dd($appSettings);
        $cards = $this->infoCardRepository->findBy([], ['ordering' => 'ASC']);

        //dd($cards);
        return $this->render('index/index.html.twig', [
            'cards' => $cards,
            'bg' => $bg,
            'title' => $title,
            'blogEnabled' => $blogEnabled,
        ]);
    }
}
