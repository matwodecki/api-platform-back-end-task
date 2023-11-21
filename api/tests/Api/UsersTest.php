<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;
use App\Repository\UserRepository;
use Zenstruck\Foundry\Test\ResetDatabase;
use App\Entity\User;

class UsersTest extends ApiTestCase
{
    use ResetDatabase;

    private Client $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testGetUsers(): void
    {
        $response = $this->client->request('GET', '/users');
        $this->assertResponseIsSuccessful();

        $users = $response->toArray()['hydra:member'];

        $this->assertCount(1, $users);
    }

    public function testAddUser(): void
    {
        $response = $this->client->request('POST', '/users', ['json' => [
            'email' => 'user2@example.com',
            'plainPassword' => 'password'
        ]]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@context' => '/contexts/User',
            '@type' => 'User',
            'email' => 'user2@example.com'
        ]);
        $this->assertMatchesRegularExpression('~^/users/\d+$~', $response->toArray()['@id']);
    }

    public function testAddExistingUser(): void
    {
        $response = $this->client->request('POST', '/users', ['json' => [
            'email' => 'user@example.com',
            'plainPassword' => 'password'
        ]]);

        $this->assertResponseStatusCodeSame(422);
    }
}
