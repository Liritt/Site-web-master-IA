<?php


namespace App\Tests\Controller\Internship;

use App\Factory\InternshipFactory;
use App\Tests\Support\ControllerTester;

class ShowCest
{
    public function isRouteValid(ControllerTester $I): void
    {
        InternshipFactory::createMany(5);
        $I->amOnPage('/fr/internship/1');
        $I->seeResponseCodeIsSuccessful();
    }
}
