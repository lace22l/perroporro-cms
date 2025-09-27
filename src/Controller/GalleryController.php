<?php

namespace App\Controller;

use App\Entity\Artwork;
use App\Repository\ArtworkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GalleryController extends AbstractController
{
    private ArtworkRepository $artworkRepository;

    public function __construct(ArtworkRepository $artworkRepository)
    {
        $this->artworkRepository = $artworkRepository;
    }

    #[Route('/gallery', name: 'app_gallery')]
    #[Route('/gallery/folder/{folderName}', name: 'app_gallery_folder')]
    public function index(?string $folderName): Response
    {
        $folders = $this->artworkRepository->getFolders();
        if ($folderName === null) {
            $artworks = $this->artworkRepository->findAll();

        }
        else{
            $artworks = $this->artworkRepository->findBy(['folderName' => $folderName]);
        }
        return $this->render('gallery/index.html.twig', [
            'controller_name' => 'GalleryController',
            'artworks' => $artworks,
            'folders' => $folders,
        ]);
    }
    #[Route('/gallery/{artwork}', name: 'app_gallery_detail')]
    public function detail(Artwork $artwork): Response
    {

        return $this->render('gallery/detail.html.twig', [

            'artwork' => $artwork,
        ]);
    }
}
