<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Form\BlogPostType;
use App\Repository\BlogPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/blogpost')]
final class BlogPostController extends AbstractController
{
    #[Route(name: 'app_blog_post_index', methods: ['GET'])]
    public function index(BlogPostRepository $blogPostRepository): Response
    {
        return $this->render('blog_post/index.html.twig', [
            'blog_posts' => $blogPostRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_blog_post_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $blogPost = new BlogPost();
        $form = $this->createForm(BlogPostType::class, $blogPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $blogPost->setAuthor($this->getUser());
            $public = $form->get('public')->getData();
            if ($public) {
                $blogPost->setPublishedAt(new \DateTimeImmutable());
            }
            else{
                $blogPost->setPublishedAt(null);
            }
            $entityManager->persist($blogPost);
            $entityManager->flush();

            return $this->redirectToRoute('app_blog_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('blog_post/new.html.twig', [
            'blog_post' => $blogPost,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_blog_post_show', methods: ['GET'])]
    public function show(BlogPost $blogPost): Response
    {
        return $this->render('blog_post/show.html.twig', [
            'blog_post' => $blogPost,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_blog_post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BlogPost $blogPost, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BlogPostType::class, $blogPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $public = $form->get('public')->getData();
            if ($public) {
                if ($blogPost->getPublishedAt() === null) {
                    $blogPost->setPublishedAt(new \DateTimeImmutable());
                }

            }
            else{
                $blogPost->setPublishedAt(null);
            }
            $blogPost->setUpdatedAt(new \DateTimeImmutable());
            $entityManager->flush();

            return $this->redirectToRoute('app_blog_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('blog_post/edit.html.twig', [
            'blog_post' => $blogPost,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_blog_post_delete', methods: ['POST'])]
    public function delete(Request $request, BlogPost $blogPost, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$blogPost->getId(), $request->getPayload()->getString('_token'))) {
            $blogPost->setDeletedAt(new \DateTimeImmutable());
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_blog_post_index', [], Response::HTTP_SEE_OTHER);
    }
}
