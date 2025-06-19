<?php

declare(strict_types=1);

namespace Tests\Controllers;

use App\Controllers\HomeController;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Factory\ServerRequestFactory;

class HomeControllerTest extends TestCase
{
    private HomeController $controller;
    private ServerRequestFactory $requestFactory;
    private ResponseFactory $responseFactory;

    protected function setUp(): void
    {
        $this->controller = new HomeController();
        $this->requestFactory = new ServerRequestFactory();
        $this->responseFactory = new ResponseFactory();
    }

    public function testIndexReturnsCorrectData(): void
    {
        $request = $this->requestFactory->createServerRequest('GET', '/');
        $response = $this->responseFactory->createResponse();

        $result = $this->controller->index($request, $response);

        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals('application/json', $result->getHeaderLine('Content-Type'));

        $data = json_decode((string) $result->getBody(), true);
        
        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('version', $data);
        $this->assertArrayHasKey('status', $data);
        $this->assertArrayHasKey('timestamp', $data);
        $this->assertEquals('online', $data['status']);
        $this->assertEquals('1.0.0', $data['version']);
        $this->assertEquals('Bem-vindo à aplicação DAST/SCM/SAST', $data['message']);
    }

    public function testIndexReturnsValidJson(): void
    {
        $request = $this->requestFactory->createServerRequest('GET', '/');
        $response = $this->responseFactory->createResponse();

        $result = $this->controller->index($request, $response);

        $body = (string) $result->getBody();
        $this->assertNotFalse(json_decode($body));
    }

    public function testIndexReturnsCorrectTimestamp(): void
    {
        $request = $this->requestFactory->createServerRequest('GET', '/');
        $response = $this->responseFactory->createResponse();

        $result = $this->controller->index($request, $response);

        $data = json_decode((string) $result->getBody(), true);
        
        $this->assertArrayHasKey('timestamp', $data);
        $this->assertNotEmpty($data['timestamp']);
        
        // Verify timestamp is in ISO 8601 format
        $timestamp = $data['timestamp'];
        $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}[+-]\d{2}:\d{2}$/', $timestamp);
    }

    public function testIndexWithDifferentRequestMethods(): void
    {
        $methods = ['GET', 'POST', 'PUT', 'DELETE'];
        
        foreach ($methods as $method) {
            $request = $this->requestFactory->createServerRequest($method, '/');
            $response = $this->responseFactory->createResponse();

            $result = $this->controller->index($request, $response);

            $this->assertEquals(200, $result->getStatusCode());
            $this->assertEquals('application/json', $result->getHeaderLine('Content-Type'));
        }
    }
} 