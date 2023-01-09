<?php

namespace App\Tests\Controller\Security;

use App\Entity\Administrator;
use App\Entity\Company;
use App\Factory\AdministratorFactory;
use App\Factory\CompanyFactory;
use App\Factory\StudentFactory;
use App\Factory\TeacherFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class LoginCest
{
    public function LoginAdmin(ControllerTester $I): void
    {
        $user = AdministratorFactory::createOne([
            'email' => 'User@test.com',
            'password' => 'test',
            'roles' => ['ROLE_ADMIN'],
        ]);

        $realUser = $user->object();
        $I->amOnPage('/');
        $I->seeCurrentRouteIs('app_lobby_index');
        $I->seeElement('.disconnected-nav-bar');
        $I->seeInTitle('Accueil');
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/admin');
        $I->seeResponseCodeIs(200);
    }

    public function LoginStudent(ControllerTester $I): void
    {
        $user = StudentFactory::createOne([
            'email' => 'user@test.com',
            'password' => 'test',
            'roles' => ['ROLE_STUDENT'],
        ]);

        $realUser = $user->object();
        $I->amOnPage('/');
        $I->seeCurrentRouteIs('app_lobby_index');
        $I->seeElement('.disconnected-nav-bar');
        $I->seeInTitle('Accueil');
        $I->amLoggedInAs($realUser);
        $I->seeCurrentRouteIs('app_lobby_index');
        $I->seeResponseCodeIs(200);
    }

    public function LoginTeacher(ControllerTester $I): void
    {
        $user = TeacherFactory::createOne([
            'email' => 'user@test.com',
            'password' => 'test',
            'roles' => ['ROLE_TEACHER'],
        ]);

        $realUser = $user->object();
        $I->amOnPage('/');
        $I->seeCurrentRouteIs('app_lobby_index');
        $I->seeElement('.disconnected-nav-bar');
        $I->seeInTitle('Accueil');
        $I->amLoggedInAs($realUser);
        $I->seeCurrentRouteIs('app_lobby_index');
        $I->seeResponseCodeIs(200);
    }

    public function LoginCompany(ControllerTester $I): void
    {
        $user = CompanyFactory::createOne([
            'email' => 'user@test.com',
            'password' => 'test',
            'roles' => ['ROLE_COMPANY'],
        ]);

        $realUser = $user->object();
        $I->amOnPage('/');
        $I->seeCurrentRouteIs('app_lobby_index');
        $I->seeElement('.disconnected-nav-bar');
        $I->seeInTitle('Accueil');
        $I->amLoggedInAs($realUser);
        $I->seeCurrentRouteIs('app_lobby_index');
        $I->seeResponseCodeIs(200);
    }
}
