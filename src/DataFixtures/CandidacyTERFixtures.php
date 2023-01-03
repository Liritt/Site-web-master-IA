<?php

namespace App\DataFixtures;

use App\Factory\CandidacyTERFactory;
use App\Factory\StudentFactory;
use App\Factory\TERFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CandidacyTERFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        CandidacyTERFactory::createMany(50, function () {
            return [
                'student' => StudentFactory::random(),
                'ter' => TERFactory::random(),
            ];
        });
    }

    public function getDependencies(): array
    {
        return [
            StudentFixtures::class,
            TERFixtures::class,
        ];
    }
}
