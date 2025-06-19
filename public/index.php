<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use DI\ContainerBuilder;
use App\Controllers\HomeController;
use App\Controllers\HealthController;
use App\Controllers\UserController;

// Create container
$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/../app/config/container.php');
$container = $containerBuilder->build();

// Create app
$app = AppFactory::createFromContainer($container);

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add routes
$routes = require __DIR__ . '/../app/config/routes.php';
$routes($app);

// Run app
$app->run(); 