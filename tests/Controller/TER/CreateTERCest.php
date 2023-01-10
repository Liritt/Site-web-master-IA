<?php

namespace App\Tests\Controller\TER;

use App\Factory\AdministratorFactory;
use App\Factory\TeacherFactory;
use App\Tests\Support\ControllerTester;

class CreateTERCest
{
    public function _before(ControllerTester $I)
    {
    }

    public function TeacherCanAddATer(ControllerTester $I): void
    {
        /*
        $user = TeacherFactory::createOne([
            'email' => 'teacher@example.com',
            'roles' => ['ROLE_TEACHER'],
            'password' => 'test',
            'firstname' => 'Teacher',
            'lastname' => 'Tester',
        ]);
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/fr/ter/create');
        $I->fillField('ter[title]', 'TER de test');
        $I->fillField('ter[description]', 'Description de test');
        $I->selectOption('ter[teacher]', 'Tester Teacher');
        $I->click('Créer le TER');
        $I->amOnPage('/fr/ter/1');
        */
    }

    public function AdminCanAddATer(ControllerTester $I): void
    {
        /*
        TeacherFactory::createOne([
            'email' => 'teacher@example.com',
            'roles' => ['ROLE_TEACHER'],
            'password' => 'test',
            'firstname' => 'Teacher',
            'lastname' => 'Tester',
        ]);
        $user = AdministratorFactory::createOne([
            'email' => 'user@test.com',
            'password' => 'test',
            'roles' => ['ROLE_ADMIN'],
        ]);
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/fr/ter/create');
        $I->fillField('ter[title]', 'TER de test');
        $I->fillField('ter[description]', 'Description de test');
        $I->selectOption('ter[teacher]', 'Tester Teacher');
        $I->click('Créer le TER');
        $I->amOnPage('/fr/ter/1');
        */
    }
}
