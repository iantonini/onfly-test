<?php

declare(strict_types=1);

namespace HyperfTest\Integration;

use Hyperf\Testing\TestCase;

/**
 * @internal
 * @coversNothing
 */
class TokenIsRequiredTest extends TestCase
{
    private function apiEndpoint($endpoint, $statusCode, $method, $data=[])
    {
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
        $this->assertSame('token is required', $responseData['message']);

        return $responseData;
    }

    public function testTokenIsRequiredTestUser()
    {
        $endpoint = '/user';
        $method = 'post';
        $statusCode = 200;
        $responseData = $this->apiEndpoint($endpoint, $statusCode, $method);
        $this->assertSame([], $responseData['user']);
    }

    public function testTokenIsRequiredTestUsers()
    {
        $endpoint = '/users';
        $method = 'post';
        $statusCode = 200;
        $responseData = $this->apiEndpoint($endpoint, $statusCode, $method);
        $this->assertSame([], $responseData['users']);
    }

    public function testTokenIsRequiredTestUserCreate()
    {
        $endpoint = '/user/create';
        $method = 'post';
        $statusCode = 200;
        $responseData = $this->apiEndpoint($endpoint, $statusCode, $method);
        $this->assertNull($responseData['user']);
    }

    public function testTokenIsRequiredTestUserUpdate()
    {
        $endpoint = '/user/update';
        $method = 'put';
        $statusCode = 200;
        $responseData = $this->apiEndpoint($endpoint, $statusCode, $method);
        $this->assertNull($responseData['user']);
    }

    public function testTokenIsRequiredTestUserDelete()
    {
        $endpoint = '/user/delete';
        $method = 'delete';
        $statusCode = 200;

        $responseData = $this->apiEndpoint($endpoint, $statusCode, $method);
        $this->assertNull($responseData['user']);
    }


}

