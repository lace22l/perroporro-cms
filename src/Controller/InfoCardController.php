<?php

namespace App\Controller;

use App\Entity\InfoCard;
use App\Form\InfoCardType;
use App\Repository\InfoCardRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/info/card')]
final class InfoCardController extends AbstractController
{
    #[Route(name: 'app_info_card_index', methods: ['GET'])]
    public function index(InfoCardRepository $infoCardRepository): Response
    {
        return $this->render('info_card/index.html.twig', [
            'info_cards' => $infoCardRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_info_card_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $infoCard = new InfoCard();
        $form = $this->createForm(InfoCardType::class, $infoCard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($infoCard);
            $entityManager->flush();

            return $this->redirectToRoute('app_info_card_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('info_card/new.html.twig', [
            'info_card' => $infoCard,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_info_card_show', methods: ['GET'])]
    public function show(InfoCard $infoCard): Response
    {
        return $this->render('info_card/show.html.twig', [
            'info_card' => $infoCard,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_info_card_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, InfoCard $infoCard, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InfoCardType::class, $infoCard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_info_card_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('info_card/edit.html.twig', [
            'info_card' => $infoCard,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_info_card_delete', methods: ['POST'])]
    public function delete(Request $request, InfoCard $infoCard, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$infoCard->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($infoCard);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_info_card_index', [], Response::HTTP_SEE_OTHER);
    }
}
