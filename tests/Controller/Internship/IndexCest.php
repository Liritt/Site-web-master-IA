<?php

namespace App\Tests\Controller\Internship;

use App\Factory\AdministratorFactory;
use App\Factory\InternshipFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function isRouteValid(ControllerTester $I): void
    {
        $user = AdministratorFactory::createOne([
            'email' => 'admin@example.com',
            'password' => 'admin',
            'roles' => ['ROLE_ADMIN'],
        ]);
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/fr/internship');
        $I->seeResponseCodeIsSuccessful();
    }

    public function checkContent(ControllerTester $I): void
    {
        InternshipFactory::createMany(5);
        $user = AdministratorFactory::createOne([
            'email' => 'admin@example.com',
            'password' => 'admin',
            'roles' => ['ROLE_ADMIN'],
        ]);
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/fr/internship');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Liste des stages');
        $I->see('Liste des stages', 'h1');
        $I->seeNumberOfElements('.card-body', 5);
    }
}
