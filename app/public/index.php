<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Slim\Factory\AppFactory;

require __DIR__ . '/../../vendor/autoload.php';

// Carregar variáveis de ambiente
$dotenv = Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

// Configurar container DI
$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/../config/container.php');
$container = $containerBuilder->build();

// Criar aplicação Slim
$app = AppFactory::createFromContainer($container);

// Adicionar middleware de erro
$app->addErrorMiddleware(true, true, true);

// Adicionar middleware de segurança
$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    
    // Headers de segurança
    $response = $response->withHeader('X-Content-Type-Options', 'nosniff');
    $response = $response->withHeader('X-Frame-Options', 'DENY');
    $response = $response->withHeader('X-XSS-Protection', '1; mode=block');
    $response = $response->withHeader('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
    $response = $response->withHeader('Content-Security-Policy', "default-src 'self'");
    
    return $response;
});

// Configurar rotas
require __DIR__ . '/../config/routes.php';

// Executar aplicação
$app->run(); 