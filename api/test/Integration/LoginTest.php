<?php

declare(strict_types=1);

namespace HyperfTest\Integration;

use Hyperf\Testing\TestCase;

/**
 * @internal
 * @coversNothing
 */
class LoginTest extends TestCase
{
    private function getEmailUser($user)
    {
        $email = 'qualquer@email.com';
        if (!! $user && $user == 'user') {
            $email = 'user@onfly.com';
        } elseif (!! $user && $user == 'root') {
            $email = 'root@onfly.com';
        }
        return $email;
    }

    public function testGenerateToken()
    {
        $endpoint = '/login';
        $statusCode = 200;
        $data = [ 'email' => $this->getEmailUser('root') ];

        $response = $this->post($endpoint, $data);
        $this->assertSame($statusCode, $response->getStatusCode());

        $responseData = json_decode($response->getBody()->getContents(), true);
        $this->assertSame('success', $responseData['status']);
        $this->assertSame('authorized email', $responseData['message']);
        $this->assertSame('e714737374acc3e767e149f0f0e48dfe', $responseData['token']);
    }

    public function testFailsToGenerateToken()
    {
        $endpoint = '/login';
        $statusCode = 200;
        $data = [ 'email' => $this->getEmailUser('email') ];

        $response = $this->post($endpoint, $data);
        $this->assertSame($statusCode, $response->getStatusCode());

        $responseData = json_decode($response->getBody()->getContents(), true);
        $this->assertSame('unauthorized', $responseData['status']);
        $this->assertSame('unauthorized email', $responseData['message']);
        $this->assertNull($responseData['token']);
    }
}
