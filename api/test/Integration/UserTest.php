<?php

declare(strict_types=1);

namespace HyperfTest\Integration;

use Hyperf\Testing\TestCase;

/**
 * @internal
 * @coversNothing
 */
class UserTest extends TestCase
{
    private function getTokenUser($user)
    {
        $token = 'd2ec2f35e0cfb64c3262198672a770c1';
        if (!! $user && $user == 'root') {
            $token = 'e714737374acc3e767e149f0f0e48dfe';
        }
        return $token;
    }

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

        return $responseData;
    }

    public function testListMyUser()
    {
        $endpoint = '/user';
        $method = 'post';
        $statusCode = 200;
        $data = [ 'token' => $this->getTokenUser('root') ];

        $responseData = $this->apiEndpoint($endpoint, $statusCode, $method, $data);
        $this->assertSame('success', $responseData['status']);
        $this->assertSame('success', $responseData['message']);

        $user = $responseData['user'];
        $this->assertSame(1, $user['superuser']);
        $this->assertSame('Root Onfly', $user['user_name']);
        $this->assertSame('root@onfly.com', $user['email']);
    }

    public function testListAllUser()
    {
        $endpoint = '/users';
        $method = 'post';
        $statusCode = 200;
        $data = [ 'token' => $this->getTokenUser('user') ];

        $responseData = $this->apiEndpoint($endpoint, $statusCode, $method, $data);
        $this->assertSame('success', $responseData['status']);
        $this->assertSame('success', $responseData['message']);

        $user = $responseData['users'];
        $this->assertSame(0, $user['superuser']);
        $this->assertSame('User Onfly', $user['user_name']);
        $this->assertSame('user@onfly.com', $user['email']);
    }

    public function testListAllUserRoot()
    {
        $endpoint = '/users';
        $method = 'post';
        $statusCode = 200;
        $data = [ 'token' => $this->getTokenUser('root') ];

        $responseData = $this->apiEndpoint($endpoint, $statusCode, $method, $data);
        $this->assertSame('success', $responseData['status']);
        $this->assertSame('success', $responseData['message']);

        $user = $responseData['users'][0];
        $this->assertSame(1, $user['superuser']);
        $this->assertSame('Root Onfly', $user['user_name']);
        $this->assertSame('root@onfly.com', $user['email']);

        $user = $responseData['users'][1];
        $this->assertSame(0, $user['superuser']);
        $this->assertSame('User Onfly', $user['user_name']);
        $this->assertSame('user@onfly.com', $user['email']);
    }

    public function testUserCreate()
    {
        $endpoint = '/user/create';
        $method = 'post';
        $statusCode = 200;
        $idTest = (string) rand(1000,9999);
        $data = [
            'token' => $this->getTokenUser('root'),
            'user_name' => 'User Test ' . $idTest,
            'email' => 'user_test_' . $idTest . '@onfly.com',
            'superuser' => false,
        ];

        $responseData = $this->apiEndpoint($endpoint, $statusCode, $method, $data);
        $this->assertSame('success', $responseData['status']);
        $this->assertSame('user created successfully', $responseData['message']);

        $user = $responseData['user'];
        $this->assertSame($data['superuser'], $user['superuser']);
        $this->assertSame($data['user_name'], $user['user_name']);
        $this->assertSame($data['email'], $user['email']);
    }

    public function testUserUpdate()
    {
        $endpoint = '/user/update';
        $method = 'put';
        $statusCode = 200;
        $data = [
            'token' => $this->getTokenUser('root'),
            'user_name' => 'User Onfly',
            'email' => 'user@onfly.com',
            'superuser' => 0,
            'new_email' => '',
        ];

        $responseData = $this->apiEndpoint($endpoint, $statusCode, $method, $data);

        $this->assertSame('success', $responseData['status']);
        $this->assertSame('user updated successfully', $responseData['message']);

        $user = $responseData['user'];
        $this->assertSame($data['superuser'], $user['superuser']);
        $this->assertSame($data['user_name'], $user['user_name']);
        $this->assertSame($data['email'], $user['email']);
    }

    public function testUserDelete()
    {
        $endpoint = '/user/delete';
        $method = 'delete';
        $statusCode = 200;
        $data = [
            'token' => $this->getTokenUser('root'),
            'email' => 'user@onfly.com',
        ];

        $responseData = $this->apiEndpoint($endpoint, $statusCode, $method, $data);
        $this->assertSame('success', $responseData['status']);
        $this->assertSame('user deleted successfully', $responseData['message']);
        $this->assertNull($responseData['user']);
    }

    
}
