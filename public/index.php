<?php

require '../vendor/autoload.php';
$routes = require '../src/Routing/routes.php';

$dotenv = Dotenv\Dotenv::createImmutable("../");
$dotenv->safeLoad();

$app = new \Slim\App;

$routes($app);
$app->run();

