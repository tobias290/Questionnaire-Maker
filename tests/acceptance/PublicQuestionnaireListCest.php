<?php 

class PublicQuestionnaireListCest {
    public function _before(AcceptanceTester $I) {
    }

    /**
     * Test to see that the page loads a list of public questionnaires.
     *
     * @param AcceptanceTester $I
     */
    public function loadList(AcceptanceTester $I) {
        $I->am("Respondent");
        // And
        $I->wantTo("find a questionnaire from the public list to answer");
        // And
        $I->amOnFrontEndPage("public/questionnaires");
        // And
        $I->see("Public Questionnaires");
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->seeElement(".questionnaire-list-item");
    }
}
