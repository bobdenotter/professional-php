<?php declare (strict_types = 1);

namespace SocialNews\Framework\Rendering;

use Twig_Loader_Filesystem;
use Twig\Environment;

final class TwigTemplateRendererFactory
{

    public function __construct(TemplateDirectory $templateDirectory)
    {
        $this->templateDirectory = $templateDirectory;
    }


    public function create() : TwigTemplateRenderer
    {
        $templateDirectory = $this->templateDirectory->toString();
        $loader = new Twig_Loader_Filesystem([$templateDirectory]);
        $twigEnvironment = new Environment($loader);

        return new TwigTemplateRenderer($twigEnvironment);
    }
}
