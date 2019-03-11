<?php
namespace Step\Acceptance;

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

        $I->amOnPage("sign-up");
        // And
        $I->see("Sign Up");
        // And
        $I->submitForm("#signup", [
            "email" => "tobiascompany@gmail.com",
            "first_name" => "Toby",
            "surname" => "Essex",
            "password" => "pass1234",
            "confirm_password" => "pass1234",
        ]);
        // Then
        $I->seeInCurrentUrl("/dashboard");
        // And
        $I->see("Dashboard", "div.top-bar-left");
        // And
        $I->see("tobiascompany@gmail.com");
    }

    /**
     * Test to see when the user logs in they can see there dashboard.
     */
    public function login() {
        $I = $this;

        $I->signUp();
        // Then
        $I->amOnPage("login");
        // And
        $I->see("Log In");
        // And
        $I->submitForm("#login", [
            "email" => "tobiascompany@gmail.com",
            "password" => "pass1234",
        ]);
        // Then
        $I->seeInCurrentUrl("/dashboard");
        // And
        $I->see("Dashboard", "div.top-bar-left");
        // And
        $I->see("tobiascompany@gmail.com");
    }
}