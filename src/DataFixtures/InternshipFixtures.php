<?php

namespace App\DataFixtures;

use App\Factory\InternshipFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class InternshipFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        InternshipFactory::createMany(40);
    }
}
