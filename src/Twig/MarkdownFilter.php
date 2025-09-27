<?php

declare(strict_types=1);

namespace App\Twig;

use FastVolt\Helper\Markdown;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigFilter;

class MarkdownFilter extends AbstractExtension
{


    public function getFilters(): array
    {
        return [
            new TwigFilter('mdtohtml', [$this, 'mdtoHTML'])

        ];
    }

    public function mdtoHTML($text): string
    {
        $markdown = new Markdown();
        $markdown->setContent($text);
        return  $markdown->toHtml();

    }
}
