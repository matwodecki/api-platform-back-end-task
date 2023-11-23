<?php

namespace App\DataFixtures;

use App\Story\DefaultFixturesStory;
use App\Story\DefaultUsersStory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        DefaultFixturesStory::load();
        DefaultUsersStory::load();
    }
}
