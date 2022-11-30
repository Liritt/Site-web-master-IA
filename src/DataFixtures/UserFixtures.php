<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createSequence([
            ['email' => 'admin@example.com', 'roles' => ['ROLE_ADMIN'], 'password' => 'admin', 'firstname' => 'Evan', 'lastname' => 'Pluchart'],
            ['email' => 'user@example.com', 'roles' => ['ROLE_USER'], 'password' => 'test', 'firstname' => 'Gaetan', 'lastname' => 'Lemont'],
        ]);
        UserFactory::createMany(10);
    }
}
