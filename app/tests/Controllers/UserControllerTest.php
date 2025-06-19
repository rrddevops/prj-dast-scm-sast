<?php

declare(strict_types=1);

namespace Tests\Controllers;

use App\Controllers\UserController;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Factory\ServerRequestFactory;

class UserControllerTest extends TestCase
{
    private UserController $controller;
    private ServerRequestFactory $requestFactory;
    private ResponseFactory $responseFactory;

    protected function setUp(): void
    {
        $this->controller = new UserController();
        $this->requestFactory = new ServerRequestFactory();
        $this->responseFactory = new ResponseFactory();
    }

    public function testIndexReturnsUsersList(): void
    {
        $request = $this->requestFactory->createServerRequest('GET', '/api/users');
        $response = $this->responseFactory->createResponse();

        $result = $this->controller->index($request, $response);

        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals('application/json', $result->getHeaderLine('Content-Type'));

        $data = json_decode((string) $result->getBody(), true);

        $this->assertIsArray($data);
        $this->assertNotEmpty($data);
        $this->assertArrayHasKey('id', $data[0]);
        $this->assertArrayHasKey('name', $data[0]);
        $this->assertArrayHasKey('email', $data[0]);
    }

    public function testIndexReturnsValidJson(): void
    {
        $request = $this->requestFactory->createServerRequest('GET', '/api/users');
        $response = $this->responseFactory->createResponse();

        $result = $this->controller->index($request, $response);

        $body = (string) $result->getBody();
        $this->assertNotFalse(json_decode($body));
    }

    public function testStoreCreatesNewUser(): void
    {
        $userData = ['name' => 'Test User', 'email' => 'test@example.com'];
        $request = $this->requestFactory->createServerRequest('POST', '/api/users')
            ->withParsedBody($userData);
        $response = $this->responseFactory->createResponse();

        $result = $this->controller->store($request, $response);

        $this->assertEquals(201, $result->getStatusCode());
        $this->assertEquals('application/json', $result->getHeaderLine('Content-Type'));

        $data = json_decode((string) $result->getBody(), true);

        $this->assertArrayHasKey('id', $data);
        $this->assertEquals($userData['name'], $data['name']);
        $this->assertEquals($userData['email'], $data['email']);
    }

    public function testStoreReturnsErrorForMissingName(): void
    {
        $userData = ['email' => 'test@example.com'];
        $request = $this->requestFactory->createServerRequest('POST', '/api/users')
            ->withParsedBody($userData);
        $response = $this->responseFactory->createResponse();

        $result = $this->controller->store($request, $response);

        $this->assertEquals(400, $result->getStatusCode());

        $data = json_decode((string) $result->getBody(), true);
        $this->assertArrayHasKey('error', $data);
    }

    public function testStoreReturnsErrorForMissingEmail(): void
    {
        $userData = ['name' => 'Test User'];
        $request = $this->requestFactory->createServerRequest('POST', '/api/users')
            ->withParsedBody($userData);
        $response = $this->responseFactory->createResponse();

        $result = $this->controller->store($request, $response);

        $this->assertEquals(400, $result->getStatusCode());

        $data = json_decode((string) $result->getBody(), true);
        $this->assertArrayHasKey('error', $data);
    }

    public function testStoreReturnsErrorForEmptyData(): void
    {
        $userData = [];
        $request = $this->requestFactory->createServerRequest('POST', '/api/users')
            ->withParsedBody($userData);
        $response = $this->responseFactory->createResponse();

        $result = $this->controller->store($request, $response);

        $this->assertEquals(400, $result->getStatusCode());

        $data = json_decode((string) $result->getBody(), true);
        $this->assertArrayHasKey('error', $data);
    }

    public function testStoreReturnsErrorForNullData(): void
    {
        $request = $this->requestFactory->createServerRequest('POST', '/api/users')
            ->withParsedBody(null);
        $response = $this->responseFactory->createResponse();

        $result = $this->controller->store($request, $response);

        $this->assertEquals(400, $result->getStatusCode());

        $data = json_decode((string) $result->getBody(), true);
        $this->assertArrayHasKey('error', $data);
    }

    public function testStoreWithStringValues(): void
    {
        $userData = ['name' => '123', 'email' => '456'];
        $request = $this->requestFactory->createServerRequest('POST', '/api/users')
            ->withParsedBody($userData);
        $response = $this->responseFactory->createResponse();

        $result = $this->controller->store($request, $response);

        $this->assertEquals(201, $result->getStatusCode());

        $data = json_decode((string) $result->getBody(), true);
        $this->assertEquals('123', $data['name']);
        $this->assertEquals('456', $data['email']);
    }

    public function testShowReturnsUser(): void
    {
        $request = $this->requestFactory->createServerRequest('GET', '/api/users/1');
        $response = $this->responseFactory->createResponse();

        $result = $this->controller->show($request, $response, ['id' => 1]);

        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals('application/json', $result->getHeaderLine('Content-Type'));

        $data = json_decode((string) $result->getBody(), true);

        $this->assertEquals(1, $data['id']);
        $this->assertArrayHasKey('name', $data);
        $this->assertArrayHasKey('email', $data);
    }

    public function testShowReturnsErrorForInvalidUser(): void
    {
        $request = $this->requestFactory->createServerRequest('GET', '/api/users/999');
        $response = $this->responseFactory->createResponse();

        $result = $this->controller->show($request, $response, ['id' => 999]);

        $this->assertEquals(404, $result->getStatusCode());

        $data = json_decode((string) $result->getBody(), true);
        $this->assertArrayHasKey('error', $data);
    }

    public function testShowWithStringId(): void
    {
        $request = $this->requestFactory->createServerRequest('GET', '/api/users/1');
        $response = $this->responseFactory->createResponse();

        $result = $this->controller->show($request, $response, ['id' => '1']);

        $this->assertEquals(200, $result->getStatusCode());

        $data = json_decode((string) $result->getBody(), true);
        $this->assertEquals(1, $data['id']);
    }

    public function testShowReturnsValidJson(): void
    {
        $request = $this->requestFactory->createServerRequest('GET', '/api/users/1');
        $response = $this->responseFactory->createResponse();

        $result = $this->controller->show($request, $response, ['id' => 1]);

        $body = (string) $result->getBody();
        $this->assertNotFalse(json_decode($body));
    }
} 