<?php

namespace App\Tests\Controller\Security;

use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class LoginCest
{
    public function LoginAdmin(ControllerTester $I)
    {
        $user = UserFactory::createOne([
            'email' => 'user@test.com',
            'password' => 'test',
            'roles' => ['ROLE_STUDENT'],
        ]);

        $realUser = $user->object();

        $I->amLoggedInAs($realUser);

        $I->amOnPage('/login');

        $I->seeInTitle('Log in!');
    }

    public function LoginStudent(ControllerTester $I)
    {
    }

    public function LoginTeacher(ControllerTester $I)
    {
    }

    public function LoginCompany(ControllerTester $I)
    {
    }
}
