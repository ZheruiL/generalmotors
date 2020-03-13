<?php

class LoginCest
{
    public function internalLoginById(\FunctionalTester $I)
    {
        $I->amLoggedInAs(100);
        $I->amOnPage('/');
        $I->see('Logout (admin)');
    }
}