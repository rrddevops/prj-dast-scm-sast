<?php

declare(strict_types=1);

use App\Controllers\HealthController;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    // Rota principal
    $app->get('/', [HomeController::class, 'index']);
    
    // Rota de health check
    $app->get('/health', [HealthController::class, 'index']);
    
    // Rotas da API
    $app->group('/api', function (RouteCollectorProxy $group) {
        $group->get('/users', [UserController::class, 'index']);
        $group->post('/users', [UserController::class, 'store']);
        $group->get('/users/{id}', [UserController::class, 'show']);
    });
}; 