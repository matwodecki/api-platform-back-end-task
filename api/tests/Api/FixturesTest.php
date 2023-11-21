<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;
use App\Repository\UserRepository;
use Zenstruck\Foundry\Test\ResetDatabase;
use App\Entity\Fixture;

class FixturesTest extends ApiTestCase
{
    use ResetDatabase;

    private Client $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('user@example.com');
        $this->client->loginUser($testUser);
    }

    public function testGetFixtures(): void
    {
        $response = $this->client->request('GET', '/fixtures');
        $this->assertResponseIsSuccessful();

        $fixtures = $response->toArray()['hydra:member'];

        $this->assertCount(5, $fixtures);

        for ($i=1; $i < count($fixtures); $i++) {
            if ($fixtures[$i - 1]['orderDate'] < $fixtures[$i]['orderDate']) {
                $this->assertTrue(false, "Incorrectly sorted");
                break;
            }
        }
    }

    public function testPostNewFixture(): void
    {
        $response = $this->client->request('POST', '/fixtures', ['json' => [
            'brand' => 'test',
            'model' => 'test',
            'serialNumber' => '0000',
            'orderDate' => '2022-11-06T00:00:00+00:00',
            'description' => 'test',
            'status' => 'nowe'
        ]]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@context' => '/contexts/Fixture',
            '@type' => 'Fixture',
            'brand' => 'test',
            'model' => 'test',
            'serialNumber' => '0000',
            'orderDate' => '2022-11-06T00:00:00+00:00',
            'description' => 'test',
            'status' => 'nowe'
        ]);
        $this->assertMatchesRegularExpression('~^/fixtures/\d+$~', $response->toArray()['@id']);
        $this->assertMatchesResourceItemJsonSchema(Fixture::class);
    }

    public function testInvalidFixture(): void
    {
        $response = $this->client->request('POST', '/fixtures', ['json' => [
            'brand' => 'test'
        ]]);

        $this->assertResponseStatusCodeSame(422);
    }
}
