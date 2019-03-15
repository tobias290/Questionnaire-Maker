<?php 

class DashboardCest {
    public function _before(\Step\Acceptance\QuestionnaireMaker $I) {
    }

    /**
     * Test to see once logged in that I once on the dashboard I see my email address and can create questionnaires.
     *
     * @param \Step\Acceptance\QuestionnaireMaker $I
     */
    public function viewDashboard(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("see my dashboard so I create questionnaires");
        // Then
        $I->login();
        // And
        $I->wait(1);
        // And
        $I->amOnFrontEndPage("/dashboard");
        // And
        $I->see("Dashboard");
        // And
        $I->see("tobysx@gmail.com");
        // And
        $I->see("Create Questionnaire");
    }

    /**
     * Test to see when I navigate to dashboard without logging in that I am automatically redirected to log in page.
     *
     * @param \Step\Acceptance\QuestionnaireMaker $I
     */
    public function viewDashboardWithoutLoggingIn(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->expectTo("be redirected to log in page");
        // And
        $I->executeJS("sessionStorage.clear()");
        // And
        $I->reloadPage();
        // And
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
