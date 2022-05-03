<?php

require '../vendor/autoload.php';
$routes = require __DIR__ . '/../src/Routing/routes.php';

$app = new \Slim\App;

$routes($app);
$app->run();

