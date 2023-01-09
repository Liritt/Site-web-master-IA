<?php


namespace App\Tests\Controller\TER;

use App\Factory\StudentFactory;
use App\Factory\TERFactory;
use App\Tests\Support\ControllerTester;

class ViewTERPageCest
{
    public function _before(ControllerTester $I)
    {
    }

    public function PageHasGoodAmountOfTer(ControllerTester $I): void
    {
        /*
        TERFactory::createMany(5);
        $user = StudentFactory::createOne([
            'email' => 'admin@example.com',
            'password' => 'admin',
            'roles' => ['ROLE_Student'],
        ]);
        $realUser = $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/fr/ter');
        $I->seeResponseCodeIsSuccessful();
        $I->seeNumberOfElements('.card-body', 5);
        $I->seeNumberOfElements('.card-body > a', 5);
        */
    }
}
