<?php
namespace Step\Acceptance;

use mysql_xdevapi\Exception;

/**
 * Class QuestionnaireMaker
    * This class holds test specific to the role of questionnaire maker.
 * @package Step\Acceptance
 */
class QuestionnaireMaker extends \AcceptanceTester {

    /**
     * Test to see when the user signs up it logs them in and redirects them to their dashboard.
     */
    public function signUp() {
        $I = $this;

        $I->amOnFrontEndPage("sign-up");
        // And
        $I->see("Sign Up");
        // Then
        $I->fillField("email", "tobysx@gmail.com");
        $I->fillField("firstName", "Toby");
        $I->fillField("surname", "Essex");
        $I->fillField("confirmPassword", "pass1234");
        $I->fillField("password", "pass1234");
        // And
        $I->click("Sign Up");
        // Then
        $I->wait(1);
        // And Then
        $I->seeInCurrentUrl("dashboard");
        // And
        $I->see("Dashboard", "div.top-bar-left");
        // And
        //$I->see("tobysx@gmail.com");

        $I->seeInDatabase("user", [
            "email" => "tobysx@gmail.com",
            "first_name" => "Toby",
            "surname" => "Essex",
        ]);
    }

    /**
     * Test to see when the user logs in they can see there dashboard.
     *
     * @param bool $signUp - Run the sign up action. If false the sign up action will not be ran.
     */
    public function login($signUp = true) {
        $I = $this;

        if ($signUp)
            $I->signUp();

        $I->amOnFrontEndPage("login");
        // And
        $I->see("Log In");
        // Then
        $I->fillField("email", "tobysx@gmail.com");
        $I->fillField("password", "pass1234");
        // And
        $I->click("Log In");
        // Then
        $I->wait(1);
        // And Then
        $I->seeInCurrentUrl("dashboard");
        // And
        $I->see("Dashboard", "div.top-bar-left");
        // And
        //$I->see("tobysx@gmail.com");
    }
}