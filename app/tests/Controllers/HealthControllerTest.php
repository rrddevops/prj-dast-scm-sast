<?php

declare(strict_types=1);

namespace Tests\Controllers;

use App\Controllers\HealthController;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Factory\ServerRequestFactory;

class HealthControllerTest extends TestCase
{
    private HealthController $controller;
    private ServerRequestFactory $requestFactory;
    private ResponseFactory $responseFactory;

    protected function setUp(): void
    {
        $this->controller = new HealthController();
        $this->requestFactory = new ServerRequestFactory();
        $this->responseFactory = new ResponseFactory();
    }

    public function testIndexReturnsCorrectData(): void
    {
        $request = $this->requestFactory->createServerRequest('GET', '/health');
        $response = $this->responseFactory->createResponse();

        $result = $this->controller->index($request, $response);

        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals('application/json', $result->getHeaderLine('Content-Type'));

        $data = json_decode((string) $result->getBody(), true);
        
        $this->assertArrayHasKey('status', $data);
        $this->assertArrayHasKey('uptime', $data);
        $this->assertArrayHasKey('timestamp', $data);
        $this->assertEquals('healthy', $data['status']);
        $this->assertIsInt($data['uptime']);
        $this->assertNotEmpty($data['timestamp']);
    }

    public function testIndexReturnsValidJson(): void
    {
        $request = $this->requestFactory->createServerRequest('GET', '/health');
        $response = $this->responseFactory->createResponse();

        $result = $this->controller->index($request, $response);

        $body = (string) $result->getBody();
        $this->assertNotFalse(json_decode($body));
    }
} 