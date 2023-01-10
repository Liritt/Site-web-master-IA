<?php

namespace App\Tests\Controller\Trombinoscope;

use App\Factory\AdministratorFactory;
use App\Factory\StudentFactory;
use App\Factory\TeacherFactory;
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

    public function TestRouteCompany(ControllerTester $I)
    {
        $user = AdministratorFactory::createOne([
            'email' => 'admin@example.com',
            'password' => 'admin',
            'roles' => ['ROLE_ADMIN'],
        ]);
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/fr/company');
        $I->seeResponseCodeIsSuccessful();
    }

    public function TestPageStudent(ControllerTester $I)
    {
        StudentFactory::createMany(10);
        $user = AdministratorFactory::createOne([
            'email' => 'admin@example.com',
            'password' => 'admin',
            'roles' => ['ROLE_ADMIN'],
        ]);
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/fr/student');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Page trombinoscope');
        $I->seeNumberOfElements('.card-body > img', 10);
        $I->seeNumberOfElements('.card-body > .student', 10);
        $I->seeNumberOfElements('.a-own', 10);
    }

    public function TestPageStudentDegree1(ControllerTester $I)
    {
        StudentFactory::createOne([
            'firstname' => 'Exemple',
            'lastname' => 'Lastname',
            'birthdate' => '1999-06-28',
            'email' => 'student@exemple.com',
            'degree' => 1,
            'roles' => ['ROLE_STUDENT'],
            'password' => 'test',
        ]);
        StudentFactory::createOne([
            'firstname' => 'Test',
            'lastname' => 'LastnameTest',
            'birthdate' => '1999-06-28',
            'email' => 'student@exemple.com',
            'degree' => 1,
            'roles' => ['ROLE_STUDENT'],
            'password' => 'test',
        ]);
        StudentFactory::createOne([
            'firstname' => 'Exemple',
            'lastname' => 'Lastname',
            'birthdate' => '1999-06-28',
            'email' => 'student@exemple.com',
            'degree' => 2,
            'roles' => ['ROLE_STUDENT'],
            'password' => 'test',
        ]);
        $user = AdministratorFactory::createOne([
            'email' => 'admin@example.com',
            'password' => 'admin',
            'roles' => ['ROLE_ADMIN'],
        ]);
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/fr/student/1');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Page trombinoscope');
        $I->seeNumberOfElements('.card-body > img', 2);
        $I->seeNumberOfElements('.card-body > .student', 2);
        $I->seeNumberOfElements('.a-own', 2);
    }

    public function TestPageStudentDegree2(ControllerTester $I)
    {
        StudentFactory::createOne([
            'firstname' => 'Exemple',
            'lastname' => 'Lastname',
            'birthdate' => '1999-06-28',
            'email' => 'student@exemple.com',
            'degree' => 2,
            'roles' => ['ROLE_STUDENT'],
            'password' => 'test',
        ]);
        StudentFactory::createOne([
            'firstname' => 'Test',
            'lastname' => 'LastnameTest',
            'birthdate' => '1999-06-28',
            'email' => 'student@exemple.com',
            'degree' => 1,
            'roles' => ['ROLE_STUDENT'],
            'password' => 'test',
        ]);
        StudentFactory::createOne([
            'firstname' => 'Exemple',
            'lastname' => 'Lastname',
            'birthdate' => '1999-06-28',
            'email' => 'student@exemple.com',
            'degree' => 2,
            'roles' => ['ROLE_STUDENT'],
            'password' => 'test',
        ]);
        $user = AdministratorFactory::createOne([
            'email' => 'admin@example.com',
            'password' => 'admin',
            'roles' => ['ROLE_ADMIN'],
        ]);
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/fr/student/1');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Page trombinoscope');
        $I->seeNumberOfElements('.card-body > img', 2);
        $I->seeNumberOfElements('.card-body > .student', 2);
        $I->seeNumberOfElements('.a-own', 2);
    }

    public function testClicStudent(ControllerTester $I): void
    {
        StudentFactory::createMany(5);
        StudentFactory::createOne([
            'lastname' => 'Aaaaaaaaaaaaaaa',
            'firstname' => 'Joe',
            'birthdate' => '1999-06-28',
            'email' => 'student@exemple.com',
            'degree' => 2,
            'roles' => ['ROLE_STUDENT'],
            'password' => 'test',
        ]);

        $I->amOnPage('/fr/student');
        $I->seeResponseCodeIsSuccessful();
        $I->click('Aaaaaaaaaaaaaaa Joe');
        $I->seeResponseCodeIsSuccessful();
        $I->canSeeCurrentRouteIs('app_student_profil', ['id' => 6]);
    }

    public function TestPageTeacher(ControllerTester $I)
    {
        TeacherFactory::createMany(10);
        $user = AdministratorFactory::createOne([
            'email' => 'admin@example.com',
            'password' => 'admin',
            'roles' => ['ROLE_ADMIN'],
        ]);
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/fr/teacher');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Page trombinoscope');
        $I->seeNumberOfElements('.card-body > img', 10);
        $I->seeNumberOfElements('.card-body > .teacher', 10);
        $I->seeNumberOfElements('.a-own', 10);
    }

    public function testClicTeacher(ControllerTester $I): void
    {
        StudentFactory::createMany(5);
        StudentFactory::createOne([
            'lastname' => 'Bob',
            'firstname' => 'bob_bob',
            'birthdate' => '1999-06-28',
            'email' => 'teacher@exemple.com',
            'roles' => ['ROLE_TEACHER'],
            'password' => 'test',
        ]);

        $I->amOnPage('/fr/teacher');
        $I->seeResponseCodeIsSuccessful();
        $I->click('Bob bob_bob');
        $I->seeResponseCodeIsSuccessful();
        $I->canSeeCurrentRouteIs('app_teacher_profil', ['id' => 6]);
    }
}
