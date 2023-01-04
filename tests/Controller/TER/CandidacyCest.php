<?php

namespace App\Tests\Controller\TER;

use App\Factory\StudentFactory;
use App\Factory\TERFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class CandidacyCest
{
    public function _before(ControllerTester $I)
    {
    }

    public function Candidate(ControllerTester $I): void
    {
        $user = StudentFactory::createOne([
            'email' => 'user@test.com',
            'password' => 'test',
            'roles' => ['ROLE_STUDENT'],
        ]);
        for ($ter = 0; $ter < 10; ++$ter) {
            TERFactory::createOne();
        }
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/ter');
        $I->seeNumberOfElements('.lst-ter > div', 10);
        $I->seeNumberOfElements('.lst-candidacies', 0);
        $I->click('.lst-ter > div > .card > .card-body > .btn-secondary');
        $I->seeCurrentRouteIs('app_ter_toCandidate');
        $I->click('#form_add');
        $I->seeCurrentRouteIs('app_ter');
        $I->seeNumberOfElements('.lst-ter', 10);
        $I->seeNumberOfElements('.lst-candidacies', 1);
    }
}
