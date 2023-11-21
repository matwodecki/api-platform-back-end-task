<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Repository\UserRepository;

class FixturesTest extends ApiTestCase
{
    public function testGetFixtures(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('user@example.com');
        $client->loginUser($testUser);

        $response = $client->request('GET', '/fixtures');
        $this->assertResponseIsSuccessful();
    }
}
