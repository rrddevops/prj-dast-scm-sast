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
    }
} 