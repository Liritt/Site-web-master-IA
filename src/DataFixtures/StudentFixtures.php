<?php

namespace App\DataFixtures;

use App\Factory\StudentFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StudentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        StudentFactory::createSequence([
            ['email' => 'test@example.com', 'roles' => ['ROLE_USER'], 'password' => 'test'],
            ['email' => 'user@example.com', 'roles' => ['ROLE_USER'], 'password' => 'test'],
        ]);
        StudentFactory::createMany(10);
    }
}
