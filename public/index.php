<?php

use DI\ContainerBuilder; 
use Slim\Factory\AppFactory;

require '../vendor/autoload.php';

// Loads the .env file with the environment variables
$dotenv = Dotenv\Dotenv::createImmutable("../");
$dotenv->safeLoad();

// Set up the repository dependecies (autowire) and build the container
$containerBuilder = new ContainerBuilder();
$repositories = require __DIR__ . '/../src/Routing/repositories.php';
$repositories($containerBuilder);
$container = $containerBuilder->build();

// Creates the app with the container (which has all the needed dependecies)
AppFactory::setContainer($container);
$app = AppFactory::create();

// Register the application routes
$routes = require '../src/Routing/routes.php';
$routes($app);
$app->run();

