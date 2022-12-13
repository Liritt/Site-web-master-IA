<?php

namespace App\Tests\Controller\Security;

use App\Entity\Student;
use App\Factory\StudentFactory;
use App\Tests\Support\ControllerTester;

class LoginCest
{
    public function LoginAdmin(ControllerTester $I): void
    {
        $user = StudentFactory::createOne([
            'email' => 'user@test.com',
            'password' => 'test',
            'roles' => ['ROLE_STUDENT'],
        ]);

        $realUser = $user->object();

        $I->amLoggedInAs($realUser);

        $I->amOnPage('/fr/login');

        $I->seeInTitle('Log in!');
    }

    public function LoginStudent(ControllerTester $I): void
    {
    }

    public function LoginTeacher(ControllerTester $I): void
    {
    }

    public function LoginCompany(ControllerTester $I): void
    {
    }
}
