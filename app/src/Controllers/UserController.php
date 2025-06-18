<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController
{
    /** @var array<int, array<string, string|int>> */
    private array $users = [
        ['id' => 1, 'name' => 'João Silva', 'email' => 'joao@example.com'],
        ['id' => 2, 'name' => 'Maria Santos', 'email' => 'maria@example.com'],
        ['id' => 3, 'name' => 'Pedro Costa', 'email' => 'pedro@example.com'],
    ];

    public function index(Request $request, Response $response): Response
    {
        $jsonData = json_encode($this->users, JSON_PRETTY_PRINT);
        if ($jsonData === false) {
            $jsonData = '{"error": "Failed to encode JSON"}';
        }

        $response->getBody()->write($jsonData);

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function store(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        if (!is_array($data) || !isset($data['name']) || !isset($data['email'])) {
            $error = ['error' => 'Nome e email são obrigatórios'];
            $jsonData = json_encode($error, JSON_PRETTY_PRINT);
            if ($jsonData === false) {
                $jsonData = '{"error": "Failed to encode JSON"}';
            }

            $response->getBody()->write($jsonData);

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        }

        $newUser = [
            'id' => count($this->users) + 1,
            'name' => (string) $data['name'],
            'email' => (string) $data['email'],
        ];

        $this->users[] = $newUser;

        $jsonData = json_encode($newUser, JSON_PRETTY_PRINT);
        if ($jsonData === false) {
            $jsonData = '{"error": "Failed to encode JSON"}';
        }

        $response->getBody()->write($jsonData);

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }

    /**
     * @param array<string, string> $args
     */
    public function show(Request $request, Response $response, array $args): Response
    {
        $id = (int) $args['id'];

        $user = null;
        foreach ($this->users as $u) {
            if ($u['id'] === $id) {
                $user = $u;
                break;
            }
        }

        if ($user === null) {
            $error = ['error' => 'Usuário não encontrado'];
            $jsonData = json_encode($error, JSON_PRETTY_PRINT);
            if ($jsonData === false) {
                $jsonData = '{"error": "Failed to encode JSON"}';
            }

            $response->getBody()->write($jsonData);

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
        }

        $jsonData = json_encode($user, JSON_PRETTY_PRINT);
        if ($jsonData === false) {
            $jsonData = '{"error": "Failed to encode JSON"}';
        }

        $response->getBody()->write($jsonData);

        return $response->withHeader('Content-Type', 'application/json');
    }
} 