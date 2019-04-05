<?php

use Codeception\Step\Argument\PasswordArgument;

class ResetPasswordCest {
    public function _before(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->amOnFrontEndPage("login");
    }

    public function resetPassword(AcceptanceTester $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("reset my password");
        // Then
        $I->dontSeeInDatabase("password_resets", [
            "email" => "tobysx@gmail.com"
        ]);
        // Then
        $I->click("Forgotten Password?");
        // And
        $I->seeInCurrentUrl("forgotten-password");
        // And
        $I->see("Forgotten Password");
        // Then
        $I->fillField("email", "tobysx@gmail.com");
        // And
        $I->click("Send Link");
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // Then
        $I->seeInDatabase("password_resets", [
            "email" => "tobysx@gmail.com"
        ]);
        // And
        $token = $I->grabFromDatabase("password_resets", "token", ["email" => "tobysx@gmail.com"]);
        // Then
        $I->amOnFrontEndPage("reset-password/{$token}");
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        //  And
        $I->see("Reset Password");
        // Then
        $I->fillField("newPassword", new PasswordArgument("password"));
        // And
        $I->fillField("confirmPassword", new PasswordArgument("password"));
        // Then
        $I->click("Reset Password");
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // Then
        $I->seeInCurrentUrl("login");
        // And
        $I->fillField("email", "tobysx@gmail.com");
        $I->fillField("password", new PasswordArgument("password"));
        // And
        $I->click("Log In");
        // Then
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And Then
        $I->seeInCurrentUrl("dashboard");
        // And
        $I->see("Dashboard", "div.top-bar-left");
        // And
        $I->dontSeeInDatabase("password_resets", [
            "email" => "tobysx@gmail.com"
        ]);
    }
}
