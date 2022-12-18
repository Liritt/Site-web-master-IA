<?php

namespace App\DataFixtures;

use App\Factory\TeacherFactory;
use App\Factory\TERFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TERFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        TERFactory::createMany(10, function () {
            return [
                'teacher' => TeacherFactory::random(),
            ];
        });
    }

    public function getDependencies(): array
    {
        return [
            TeacherFixtures::class,
        ];
    }
}
