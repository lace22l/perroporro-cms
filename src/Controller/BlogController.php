<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\BlogPostRepository;
use FastVolt\Helper\Markdown;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BlogController extends AbstractController
{
    private BlogPostRepository $blogPostRepository;

    public function __construct(BlogPostRepository $blogPostRepository)
    {
        $this->blogPostRepository = $blogPostRepository;
    }

    #[Route('/articles', name: 'app_blog_articles')]
    #[Route('/articles/tag/{tag}/', name: 'app_blog_articles_tag')]
    #[Route('/articles/tag/{tag}/{page}', name: 'app_blog_articles_tag_page')]
    #[Route('/articles/{page}', name: 'app_blog_articles_page')]
    public function articles(int $page = 0, string $tag = null): Response
    {
        $articlesPerPage = 10; // or whatever you use

        $articles = $this->blogPostRepository->findPublished(limit: $articlesPerPage, currentPage: $page, tag: $tag);
        $totalArticles = $this->blogPostRepository->countPublished();
        $totalPages = (int) ceil($totalArticles / $articlesPerPage) - 1;

        return $this->render('blog/articles.html.twig', [
            'articles' => $articles,
            'totalArticles' => $totalArticles,
            'currentPage' => $page,
            'totalPages'    => $totalPages,
            'tag'           => $tag,
        ]);
    }
    public function index(): Response
    {
        $blogPost = $this->blogPostRepository->findLatest();

        if (!$blogPost) {
            return new Response("No blog posts yet");
        }
        $author = $blogPost->getAuthor()->getUsername();
        $title = $blogPost->getTitle();
        $date = $blogPost->getPublishedAt()->format('d/m/Y - H:i');
        $text = $blogPost->getContent();

        // initialize markdown object
        $markdown = new Markdown(); // or Markdown::new()

        // set markdown content
        $markdown->setContent($text);

        // compile as raw HTML
        $html =  $markdown->toHtml();
        $htmlHeader = "<h1 class='display-4'>{$title}</h1>";
        $htmlHeader .= "<p class='lead'>by {$author} on {$date} </p>";
        return new Response( $htmlHeader . $html);
    }
}
