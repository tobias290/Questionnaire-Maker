<?php

use Codeception\Step\Argument\PasswordArgument;

class LogInCest {
    public function _before(AcceptanceTester $I) {

    }

    protected function loginProvider() {
        return [
            [
                "field" => "email",
                "value" => "tobysx@gmail.com",
                "missing" => "Password"
            ],
            [
                "field" => "password",
                "value" => new PasswordArgument("pass1234"),
                "missing" => "Email"
            ]
        ];
    }

    /**
     * Test to see when the user log in that they are redirected to their dashboard.
     *
     * @param \Step\Acceptance\QuestionnaireMaker $I
     */
    public function login(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("login to be able to access my account and questionnaires");
        // And
        $I->login();
    }

    /**
     * Test to see when an incorrect email is given the server response with error message
     *
     * @param \Step\Acceptance\QuestionnaireMaker $I
     */
    public function loginWithIncorrectEmail(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->expectTo("see and error because my email is incorrect");
        // And
        $I->signUp();
        // And
        $I->amOnFrontEndPage("login");
        // And
        $I->see("Log In");
        // Then
        $I->fillField("email", "incorrect@email.com");
        $I->fillField("password", new PasswordArgument("pass1234"));
        // And
        $I->click("Log In");
        // Then
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->see("Email or password is incorrect");
        // And Then
        $I->dontSeeInCurrentUrl("dashboard");
        // And
        $I->dontSee("Dashboard", "div.top-bar-left");
        // And
        //$I->dontSee("tobysx@gmail.com");
    }

    /**
     * Test to see when an incorrect password is given the server response with error message
     *
     * @param \Step\Acceptance\QuestionnaireMaker $I
     */
    public function loginWithIncorrectPassword(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->expectTo("see and error because my password is incorrect");
        // And
        $I->signUp();
        // And
        $I->amOnFrontEndPage("login");
        // And
        $I->see("Log In");
        // Then
        $I->fillField("email", "tobysx@gmail.com");
        $I->fillField("password", new PasswordArgument("incorrect_password"));
        // And
        $I->click("Log In");
        // Then
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->see("Email or password is incorrect");
        // And Then
        $I->dontSeeInCurrentUrl("dashboard");
        // And
        $I->dontSee("Dashboard", "div.top-bar-left");
        // And
        //$I->dontSee("tobysx@gmail.com");
    }

    /**
     * Test to see when a specific field is left empty that the correct error is raised and correct message is shown.
     *
     * @param \Step\Acceptance\QuestionnaireMaker $I
     * @param \Codeception\Example $example
     *
     * @dataProvider loginProvider
     * @throws Exception
     */
    public function loginWithMissingData(\Step\Acceptance\QuestionnaireMaker $I, \Codeception\Example $example) {
        $I->am("Questionnaire Maker");
        // And
        $I->expectTo("see and error message because a input field is missing");
        // And
        $I->signUp();
        // And
        $I->amOnFrontEndPage("login");
        // And
        $I->see("Log In");
        // Then
        $I->fillField($example["field"], $example["value"]);
        // And
        $I->click("Log In");
        // Then
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->see("{$example["missing"]} is required");
        // And Then
        $I->dontSeeInCurrentUrl("dashboard");
        // And
        $I->dontSee("Dashboard", "div.top-bar-left");
        // And
        //$I->dontSee("tobysx@gmail.com");
    }
}
