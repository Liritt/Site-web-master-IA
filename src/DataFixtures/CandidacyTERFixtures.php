<?php

namespace App\DataFixtures;

use App\Entity\CandidacyTER;
use App\Entity\Student;
use App\Factory\CandidacyTERFactory;
use App\Factory\StudentFactory;
use App\Factory\TERFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CandidacyTERFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $students = $manager->getRepository(Student::class)->findAll();

        foreach ($students as $student) {
            $numCandidacyTERs = $faker->numberBetween(5, 10);
            for ($i = 1; $i <= $numCandidacyTERs; ++$i) {
                CandidacyTERFactory::createOne([
                    'student' => $student,
                    'TER' => TERFactory::random(),
                    'orderNumber' => $i,
                    ]
                );
            }
        }
    }

    public function getDependencies(): array
    {
        return [
            StudentFixtures::class,
            TERFixtures::class,
        ];
    }
}
