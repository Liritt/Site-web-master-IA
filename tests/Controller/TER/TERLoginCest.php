<?php


namespace App\Tests\Controller\TER;

use App\Entity\Teacher;
use App\Factory\StudentFactory;
use App\Factory\TeacherFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class TERLoginCest
{
    public function _before(ControllerTester $I)
    {
    }

    public function CanAccessAsStudent(ControllerTester $I)
    {
        $user = StudentFactory::createOne([
            'email' => 'user@test.com',
            'password' => 'test',
            'roles' => ['ROLE_STUDENT'],
        ]);
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/fr/ter');
        $I->seeCurrentRouteIs('app_ter');
        $I->seeResponseCodeIs(200);
    }

    public function CanAccessAsTeacher(ControllerTester $I)
    {
        $user = TeacherFactory::createOne([
            'email' => 'user@test.com',
            'password' => 'test',
            'roles' => ['ROLE_TEACHER'],
        ]);
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/fr/ter');
        $I->seeCurrentRouteIs('app_ter');
        $I->seeResponseCodeIs(200);
    }

    public function CanAccessAsAdmin(ControllerTester $I)
    {
        $user = TeacherFactory::createOne([
            'email' => 'user@test.com',
            'password' => 'test',
            'roles' => ['ROLE_ADMIN'],
        ]);
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/fr/ter');
        $I->seeCurrentRouteIs('app_ter');
        $I->seeResponseCodeIs(200);
    }

    public function CantAccessAsCompany(ControllerTester $I)
    {
        $user = TeacherFactory::createOne([
            'email' => 'user@test.com',
            'password' => 'test',
            'roles' => ['ROLE_COMPANY'],
        ]);
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/fr/ter');
        $I->seeCurrentRouteIs('app_ter');
        $I->seeResponseCodeIs(403);
    }
}
