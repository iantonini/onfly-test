<?php

declare(strict_types=1);

namespace HyperfTest\Integration;

use Hyperf\Testing\TestCase;

/**
 * @internal
 * @coversNothing
 */
class TokenNotFoundTest extends TestCase
{
    private function apiEndpoint($endpoint, $statusCode, $method, $data=[])
    {
        $data = [ 'token' => '123' ];

        switch ($method) {
            case 'post':
                $response = $this->post($endpoint, $data);
                break;
            case 'put':
                $response = $this->put($endpoint, $data);
                break;
            case 'delete':
                $response = $this->delete($endpoint, $data);
                break;
            default:
                $response = $this->get($endpoint, $data);
                break;
        }
        $this->assertSame($statusCode, $response->getStatusCode());
        $responseData = json_decode($response->getBody()->getContents(), true);

        $this->assertSame('error', $responseData['status']);
        $this->assertSame('Unable to find a user with the provided token', $responseData['message']);

        return $responseData;
    }

    public function testTokenNotFoundUser()
    {
        $endpoint = '/user';
        $method = 'post';
        $statusCode = 200;
        $responseData = $this->apiEndpoint($endpoint, $statusCode, $method);
        $this->assertNull($responseData['user']);
    }

    public function testTokenNotFoundUsers()
    {
        $endpoint = '/users';
        $method = 'post';
        $statusCode = 200;
        $responseData = $this->apiEndpoint($endpoint, $statusCode, $method);
        $this->assertSame([], $responseData['users']);
    }

    public function testTokenNotFoundUserCreate()
    {
        $endpoint = '/user/create';
        $method = 'post';
        $statusCode = 200;
        $responseData = $this->apiEndpoint($endpoint, $statusCode, $method);
        $this->assertNull($responseData['user']);
    }

    public function testTokenNotFoundUserUpdate()
    {
        $endpoint = '/user/update';
        $method = 'put';
        $statusCode = 200;
        $responseData = $this->apiEndpoint($endpoint, $statusCode, $method);
        $this->assertNull($responseData['user']);
    }

    public function testTokenNotFoundUserDelete()
    {
        $endpoint = '/user/delete';
        $method = 'delete';
        $statusCode = 200;

        $responseData = $this->apiEndpoint($endpoint, $statusCode, $method);
        $this->assertNull($responseData['user']);
    }

}

