<?php

namespace App\Controller;

use App\Entity\AppSetting;
use App\Form\AppSettingType;
use App\Repository\AppSettingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/app/setting')]
final class AppSettingController extends AbstractController
{
    #[Route(name: 'app_setting_index', methods: ['GET'])]
    public function index(AppSettingRepository $appSettingRepository): Response
    {
        return $this->render('app_setting/index.html.twig', [
            'app_settings' => $appSettingRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_setting_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $appSetting = new AppSetting();
        $form = $this->createForm(AppSettingType::class, $appSetting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($appSetting);
            $entityManager->flush();

            return $this->redirectToRoute('app_setting_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('app_setting/new.html.twig', [
            'app_setting' => $appSetting,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_setting_show', methods: ['GET'])]
    public function show(AppSetting $appSetting): Response
    {
        return $this->render('app_setting/show.html.twig', [
            'app_setting' => $appSetting,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_setting_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AppSetting $appSetting, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AppSettingType::class, $appSetting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_setting_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('app_setting/edit.html.twig', [
            'app_setting' => $appSetting,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_setting_delete', methods: ['POST'])]
    public function delete(Request $request, AppSetting $appSetting, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$appSetting->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($appSetting);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_setting_index', [], Response::HTTP_SEE_OTHER);
    }
}
