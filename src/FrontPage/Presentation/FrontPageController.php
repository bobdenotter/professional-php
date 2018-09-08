<?php

declare(strict_types=1);

namespace SocialNews\FrontPage\Presentation;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use SocialNews\Framework\Rendering\TemplateRenderer;

final class FrontPageController
{
    private $templateRenderer;

    public function __construct(TemplateRenderer $templateRenderer)
    {
        $this->templateRenderer = $templateRenderer;
    }

    public function show() : Response
    {
        $submissions = [
            ['url' => 'http://google.com', 'title' => 'Google'],
            ['url' => 'http://bing.com', 'title' => 'Bing'],
        ];

        $content = $this->templateRenderer->render('FrontPage.html.twig', [
            'submissions' => $submissions,
        ]);
        return new Response($content);
    }


}
