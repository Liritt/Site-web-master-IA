<?php

namespace App\DataFixtures;

use App\Factory\StudentFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StudentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        StudentFactory::createOne([
            'email' => 'student@example.com',
            'roles' => ['ROLE_STUDENT'],
            'password' => 'test',
            'firstname' => 'Student',
            'lastname' => 'Tester',
        ]);
        StudentFactory::createOne([
            'email' => 'student2@example.com',
            'roles' => ['ROLE_STUDENT'],
            'password' => 'test',
            'firstname' => 'THESTUDENT°2',
            'lastname' => 'Tester',
        ]);
        StudentFactory::createMany(10);
    }
}
