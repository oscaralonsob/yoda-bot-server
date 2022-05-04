<?php

use DI\ContainerBuilder; 
use Slim\Factory\AppFactory;

require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable("../");
$dotenv->safeLoad();

$containerBuilder = new ContainerBuilder();
$repositories = require __DIR__ . '/../src/Routing/repositories.php';
$repositories($containerBuilder);

$container = $containerBuilder->build();

AppFactory::setContainer($container);
$app = AppFactory::create();

$routes = require '../src/Routing/routes.php';
$routes($app);
$app->run();

