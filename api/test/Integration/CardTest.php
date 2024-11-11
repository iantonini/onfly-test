<?php

declare(strict_types=1);

namespace HyperfTest\Integration;

use Hyperf\Testing\TestCase;

/**
 * @internal
 * @coversNothing
 */
class CardTest extends TestCase
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

    public function testCardCreate()
    {
        $endpoint = '/card/create';
        $method = 'post';
        $statusCode = 200;
        $data = [
            'token' => $this->getTokenUser('root'),
            'user_id' => 1,
            'balance' => 1000.00,
        ];

        $responseData = $this->apiEndpoint($endpoint, $statusCode, $method, $data);
        $this->assertSame('success', $responseData['status']);
        $this->assertSame('card created successfully', $responseData['message']);

        $card = $responseData['card'];
        $this->assertSame($data['user_id'], $card['fk_user']);
        $this->assertSame($data['balance'], $card['balance']);
        $this->assertEquals(16, strlen($card['card_number']), 'card does not have 16 digits');
    }

    public function testListMyCards()
    {
        $endpoint = '/cards/user';
        $method = 'post';
        $statusCode = 200;
        $data = [ 'token' => $this->getTokenUser('root') ];

        $this->assertSame('success', $responseData['status']);
        $this->assertSame('card created successfully', $responseData['message']);

        $card = $responseData['card'][0];
        $this->assertSame(1, $card['fk_user']);
        $this->assertSame(1000, $card['balance']);
        $this->assertSame(1000, $card['balance_created']);
        $this->assertSame(0, $card['deleted']);
        $this->assertEquals(16, strlen($card['card_number']), 'card does not have 16 digits');
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

        $card = $responseData['ucard'];
        $this->assertSame(0, $card['superuser']);
        $this->assertSame('User Onfly', $card['user_name']);
        $this->assertSame('user@onfly.com', $card['email']);
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

        $card = $responseData['ucard'][0];
        $this->assertSame(1, $card['superuser']);
        $this->assertSame('Root Onfly', $card['user_name']);
        $this->assertSame('root@onfly.com', $card['email']);

        $card = $responseData['ucard'][1];
        $this->assertSame(0, $card['superuser']);
        $this->assertSame('User Onfly', $card['user_name']);
        $this->assertSame('user@onfly.com', $card['email']);
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

        $card = $responseData['card'];
        $this->assertSame($data['superuser'], $card['superuser']);
        $this->assertSame($data['user_name'], $card['user_name']);
        $this->assertSame($data['email'], $card['email']);
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
