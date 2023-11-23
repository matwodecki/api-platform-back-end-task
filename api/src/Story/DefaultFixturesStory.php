<?php

namespace App\Story;

use App\Factory\FixtureFactory;
use Zenstruck\Foundry\Story;

final class DefaultFixturesStory extends Story
{
    public function build(): void
    {
        FixtureFactory::createMany(5);
    }
}
