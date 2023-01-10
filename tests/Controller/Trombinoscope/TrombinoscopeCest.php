<?php

namespace App\Tests\Controller\Trombinoscope;

use App\Factory\AdministratorFactory;
use App\Factory\CompanyFactory;
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
            'email' => 'student@etudiant.univ-reims.fr',
            'degree' => 1,
            'roles' => ['ROLE_STUDENT'],
            'password' => 'test',
        ]);
        StudentFactory::createOne([
            'firstname' => 'Test',
            'lastname' => 'LastnameTest',
            'birthdate' => '1999-06-28',
            'email' => 'student@etudiant.univ-reims.fr',
            'degree' => 1,
            'roles' => ['ROLE_STUDENT'],
            'password' => 'test',
        ]);
        StudentFactory::createOne([
            'firstname' => 'Exemple',
            'lastname' => 'Lastname',
            'birthdate' => '1999-06-28',
            'email' => 'student@etudiant.univ-reims.fr',
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
            'email' => 'student@etudiant.univ-reims.fr',
            'degree' => 2,
            'roles' => ['ROLE_STUDENT'],
            'password' => 'test',
        ]);
        StudentFactory::createOne([
            'firstname' => 'Test',
            'lastname' => 'LastnameTest',
            'birthdate' => '1999-06-28',
            'email' => 'student@etudiant.univ-reims.fr',
            'degree' => 1,
            'roles' => ['ROLE_STUDENT'],
            'password' => 'test',
        ]);
        StudentFactory::createOne([
            'firstname' => 'Exemple',
            'lastname' => 'Lastname',
            'birthdate' => '1999-06-28',
            'email' => 'student@etudiant.univ-reims.fr',
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
            'email' => 'student@etudiant.univ-reims.fr',
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

    public function searchStudent(ControllerTester $I): void
    {
        StudentFactory::createMany(2);
        StudentFactory::createOne([
            'lastname' => 'Marie',
            'firstname' => 'Jean',
            'birthdate' => '1999-06-28',
            'email' => 'student@etudiant.univ-reims.fr',
            'degree' => 2,
            'roles' => ['ROLE_STUDENT'],
            'password' => 'test',
        ]);
        StudentFactory::createOne([
            'lastname' => 'Michel',
            'firstname' => 'Marie',
            'birthdate' => '1999-06-28',
            'email' => 'student@etudiant.univ-reims.fr',
            'degree' => 1,
            'roles' => ['ROLE_STUDENT'],
            'password' => 'test',
        ]);

        $I->amOnPage('/fr/student');
        $I->seeResponseCodeIsSuccessful();
        $I->amOnPage('/fr/student?search=Marie');
        $liste = $I->grabMultiple('div.student');
        $I->assertEquals($liste, ['Jean Marie 2 ème année', 'Marie Michel 1 ère année']);
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
        TeacherFactory::createMany(5);
        TeacherFactory::createOne([
            'lastname' => 'Bob',
            'firstname' => 'bob_bob',
            'birthdate' => '1999-06-28',
            'email' => 'teacher@univ-reims.fr',
            'roles' => ['ROLE_TEACHER'],
            'password' => 'test',
        ]);

        $I->amOnPage('/fr/teacher');
        $I->seeResponseCodeIsSuccessful();
        $I->click('Bob bob_bob');
        $I->seeResponseCodeIsSuccessful();
        $I->canSeeCurrentRouteIs('app_teacher_profil', ['id' => 6]);
    }

    public function searchTeacher(ControllerTester $I): void
    {
        TeacherFactory::createMany(2);
        TeacherFactory::createOne([
            'lastname' => 'Marie',
            'firstname' => 'bob_bob',
            'birthdate' => '1999-06-28',
            'email' => 'teacher@univ-reims.fr',
            'roles' => ['ROLE_TEACHER'],
            'password' => 'test',
        ]);
        TeacherFactory::createOne([
            'lastname' => 'Michel',
            'firstname' => 'Marie',
            'birthdate' => '1999-06-28',
            'email' => 'teacher@univ-reims.fr',
            'roles' => ['ROLE_TEACHER'],
            'password' => 'test',
        ]);

        $I->amOnPage('/fr/teacher');
        $I->seeResponseCodeIsSuccessful();
        $I->amOnPage('/fr/teacher?search=Marie');
        $liste = $I->grabMultiple('div.teacher');
        $I->assertEquals($liste, ['bob_bob Marie', 'Marie Michel']);
    }

    public function TestPageCompany(ControllerTester $I)
    {
        CompanyFactory::createMany(10);
        $user = AdministratorFactory::createOne([
            'email' => 'admin@example.com',
            'password' => 'admin',
            'roles' => ['ROLE_ADMIN'],
        ]);
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/fr/company');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Page trombinoscope');
        $I->seeNumberOfElements('.card-body > h2', 10);
        $I->seeNumberOfElements('.card-body > img', 10);
        $I->seeNumberOfElements('.card-body > .supervisor', 10);
        $I->seeNumberOfElements('.a-own', 10);
    }

    public function testClicCompany(ControllerTester $I): void
    {
        CompanyFactory::createMany(5);
        CompanyFactory::createOne([
            'company_name' => 'Google',
            'supervisor_firstname' => 'Moi',
            'supervisor_lastname' => 'blbl',
            'email' => 'company@company.fr',
            'roles' => ['ROLE_COMPANY'],
            'password' => 'test',
        ]);

        $I->amOnPage('/fr/company');
        $I->seeResponseCodeIsSuccessful();
        $I->click('Moi blbl');
        $I->seeResponseCodeIsSuccessful();
        $I->canSeeCurrentRouteIs('app_company_profil', ['id' => 6]);
    }
}
