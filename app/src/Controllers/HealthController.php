<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HealthController
{
    public function index(Request $request, Response $response): Response
    {
        $data = [
            'status' => 'healthy',
            'uptime' => time(),
            'timestamp' => date('c'),
        ];

        $response->getBody()->write(json_encode($data, JSON_PRETTY_PRINT));

        return $response->withHeader('Content-Type', 'application/json');
    }
} 