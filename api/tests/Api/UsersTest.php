<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;
use App\Repository\UserRepository;
use App\Factory\UserFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;
use App\Entity\User;

class UsersTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    private Client $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        UserFactory::createOne(['email' => 'user@example.com']);
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

    public function testGetOneUser(): void
    {
        $user = UserFactory::random();
        $id = $user->getId();
        $iri = $this->findIriBy(User::class, ['id' => $id]);
        $this->client->request('GET', $iri);
        $this->assertResponseStatusCodeSame(200);
    }

    public function testUpdateUser(): void
    {
        $user = UserFactory::random();
        $id = $user->getId();
        $iri = $this->findIriBy(User::class, ['id' => $id]);
        $this->client->request('PATCH', $iri, [
            'json' => [
                'plainPassword' => '1234qwer'
            ],
            'headers' => [
                'Content-Type' => 'application/merge-patch+json'
            ]
        ]);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@id' => $iri
        ]);
    }

    public function testReplaceUser(): void
    {
        $user = UserFactory::random();
        $id = $user->getId();
        $iri = $this->findIriBy(User::class, ['id' => $id]);
        $response = $this->client->request('PUT', $iri, ['json' => [
            'email' => 'test@example.com',
            'plainPassword' => '1234qwer'
        ]]);
        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@context' => '/contexts/User',
            '@type' => 'User',
            'email' => 'test@example.com'
        ]);
        $this->assertMatchesRegularExpression('~^/users/\d+$~', $response->toArray()['@id']);
        $this->assertMatchesResourceItemJsonSchema(User::class);
    }

    public function testRemoveUser(): void
    {
        UserFactory::createOne(['email' => 'test@example.com']);
        $iri = $this->findIriBy(User::class, ['email' => 'test@example.com']);
        $this->client->request('DELETE', $iri);
        $this->assertResponseStatusCodeSame(204);
        static::getContainer()->get('doctrine')->getRepository(User::class)->findOneBy(['email' => 'test@example.com']);
    }
}
