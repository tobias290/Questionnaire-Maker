<?php 

class LandingPageCest {
    public function _before(AcceptanceTester $I) {
    }

    /**
     * Test to see when the user loads the page the first visible page is the landing page.
     *
     * @param AcceptanceTester $I
     */
    public function arriveOnLandingPage(AcceptanceTester $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("see the landing page");
        // When
        $I->amOnPage("/");
        $I->see("Questionnaire Maker", "div.top-bar-left");
        // And
        $I->see("Sign up for free and start making questionnaires today.");
        // And
        $I->see("Log In", "button");
        // And
        $I->see("Sign Up", "button");
        // And
        $I->see("Public Questionnaires", "button");
    }
}
