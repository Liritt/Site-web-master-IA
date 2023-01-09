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
}
