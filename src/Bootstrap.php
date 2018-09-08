<?php

declare(strict_types=1);

use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;

define('ROOT_DIR', dirname(__DIR__));
require ROOT_DIR . '/vendor/autoload.php';

Debug::enable();

$request = Request::createFromGlobals();

$content = 'Hello ' . $request->get('name', 'visitor');

$response = new \Symfony\Component\HttpFoundation\Response($content);
$response->prepare($request);
$response->send();
