<?php declare(strict_types=1);

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

define('ROOT_DIR', dirname(__DIR__));

require ROOT_DIR . '/vendor/autoload.php';

\Tracy\Debugger::enable();

$request = Request::createFromGlobals();

$dispatcher = \FastRoute\simpleDispatcher(
    function (\FastRoute\RouteCollector $r) {
        $r->addRoute(
            'GET',
            '/',
            'SocialNews\FrontPage\Presentation\FrontPageController#show'
        );
        $r->addRoute(
            'GET',
            '/submit',
            'SocialNews\Submission\Presentation\SubmissionController#show'
        );
    }
);

$routeInfo = $dispatcher->dispatch(
    $request->getMethod(),
    $request->getPathInfo()
);

switch ($routeInfo[0]) {
    case \FastRoute\Dispatcher::NOT_FOUND:
        $response = new \Symfony\Component\HttpFoundation\Response(
            'Not found',
            404
        );
        break;
    case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $response = new \Symfony\Component\HttpFoundation\Response(
            'Method not allowed',
            405
        );
        break;
    case \FastRoute\Dispatcher::FOUND:
        [$controllerName, $method] = explode('#', $routeInfo[1]);
        $vars = $routeInfo[2];
        $controller = new $controllerName;
        $response = $controller->$method($request, $vars);
        break;
}

if (!$response instanceof Response) {
    throw new \Exception('Controller methods must return a Response object');
}

$response->prepare($request);
$response->send();