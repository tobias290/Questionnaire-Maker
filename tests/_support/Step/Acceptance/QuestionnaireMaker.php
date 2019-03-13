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

        // NOTE: Due to how laravel and built angular work, you cannot start on the any page.
        // NOTE: Instead you must start on the index page and navigate from there.

        $I->amOnFrontEndPage("sign-up");
        // And
        $I->see("Sign Up");
        // Then
        $I->fillField("email", "tobiascompany@gmail.com");
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
        //$I->see("tobiascompany@gmail.com");
    }

    /**
     * Test to see when the user logs in they can see there dashboard.
     */
    public function login() {
        $I = $this;
    }
}