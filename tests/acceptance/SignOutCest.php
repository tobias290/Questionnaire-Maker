<?php 

class SignOutCest {
    public function _before(AcceptanceTester $I) {

    }

    /**
     * Test to see when the user logs out that they are redirected to the login page.
     * Also check to see that they cannot navigate back to dashboard page.
     *
     * @param \Step\Acceptance\QuestionnaireMaker $I
     */
    public function signOut(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("sign out of my account");
        // Then
        $I->expect("to be redirected to log in page");
        // First
        $I->login();
        // Then
        $I->amOnFrontEndPage("/dashboard");
        // And
        $I->see("Sign Out");
        // Then
        $I->click("Sign Out");
        // And
        $I->wait(1);
        // Then
        $I->seeInCurrentUrl("login");
        // Now
        $I->expectTo("not be able to return to my dashboard");
        // Then
        $I->amOnFrontEndPage("/dashboard");
        // And
        $I->dontSee("Dashboard");
        // And
        $I->dontSee("tobysx@gmail.com");
        // And
        $I->dontSee("Create Questionnaire");
        // And
        $I->seeInCurrentUrl("login");
    }
}
