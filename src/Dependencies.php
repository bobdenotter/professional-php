<?php declare (strict_types = 1);

use Auryn\Injector;
use SocialNews\Framework\Dbal\ConnectionFactory;
use SocialNews\Framework\Dbal\DatabaseUrl;
use SocialNews\Framework\Rendering\TemplateDirectory;
use SocialNews\Framework\Rendering\TemplateRenderer;
use SocialNews\Framework\Rendering\TwigTemplateRendererFactory;
use SocialNews\FrontPage\Application\SubmissionsQuery;
use SocialNews\FrontPage\Infrastructure\MockSubmissionsQuery;
use Symfony\Component\VarDumper\Server\Connection;

$injector = new Injector();

$injector->delegate(
    TemplateRenderer::class,
    function () use ($injector) : TemplateRenderer {
        $factory = $injector->make(TwigTemplateRendererFactory::class);
        return $factory->create();
    }
);

$injector->define(TemplateDirectory::class, [':rootDirectory' => ROOT_DIR]);


$injector->alias(SubmissionsQuery::class, MockSubmissionsQuery::class);
$injector->share(SubmissionsQuery::class);



$injector->define(
    DatabaseUrl::class,
    [':url' => 'sqlite:///' . ROOT_DIR . '/storage/db.sqlite3']
);

$injector->delegate(Connection::class, function () use ($injector) : Connection {
    $factory = $injector->make(ConnectionFactory::class);
    return $factory->create();
});

return $injector;
