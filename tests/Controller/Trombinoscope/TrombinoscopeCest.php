<?php

namespace App\Tests\Controller\Trombinoscope;

use App\Factory\AdministratorFactory;
use App\Factory\StudentFactory;
use App\Tests\Support\ControllerTester;

class TrombinoscopeCest
{
    public function TestRouteStudent(ControllerTester $I)
    {
        $user = AdministratorFactory::createOne([
            'email' => 'admin@example.com',
            'password' => 'admin',
            'roles' => ['ROLE_ADMIN'],
        ]);
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/fr/student');
        $I->seeResponseCodeIsSuccessful();
    }

    public function TestRouteTeacher(ControllerTester $I)
    {
        $user = AdministratorFactory::createOne([
            'email' => 'admin@example.com',
            'password' => 'admin',
            'roles' => ['ROLE_ADMIN'],
        ]);
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/fr/teacher');
        $I->seeResponseCodeIsSuccessful();
    }


}
