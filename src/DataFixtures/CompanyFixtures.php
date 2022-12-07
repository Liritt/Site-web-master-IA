<?php

namespace App\DataFixtures;

use App\Factory\CompanyFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CompanyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        CompanyFactory::createOne([
            'email' => 'company@example.com',
            'roles' => ['ROLE_COMPANY'],
            'password' => 'test',
            'companyName' => 'Company',
            'supervisor_firstname' => 'Company',
            'supervisor_lastname' => 'Tester'
        ]);
        CompanyFactory::createMany(10);
    }
}
