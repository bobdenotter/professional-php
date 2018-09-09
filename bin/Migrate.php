<?php declare (strict_types = 1);

use Migrations\Migration201809091205;

define('ROOT_DIR', dirname(__DIR__));

require ROOT_DIR . '/vendor/autoload.php';

$injector = include(ROOT_DIR . '/src/Dependencies.php');

$connection = $injector->make('Doctrine\DBAL\Connection');

$migration = new Migration201809091205($connection);
$migration->migrate();

echo 'Finished running migrations' . PHP_EOL;
