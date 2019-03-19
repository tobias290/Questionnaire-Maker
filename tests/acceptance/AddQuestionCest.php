<?php 

class AddQuestionCest {
    public function _before(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->signUp();
        // And
        $I->amOnFrontEndPage("dashboard");
        // And
        $I->createQuestionnaire();
        // And
        $I->seeInCurrentUrl("edit");
    }

    /**
     * Test to see that the user can successfully add an open question to a questionnaire.
     *
     * @param \Step\Acceptance\QuestionnaireMaker $I
     */
    public function addOpenQuestion(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("add an open question to my questionnaire");
        // And
        $I->click(["id" => "add-single-line-question"]);
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->seeInDatabase("question_open", [
            "name" => "Untitled",
        ]);
    }

    /**
     * Test to see that the user can successfully add a closed question to a questionnaire.
     *
     * @param \Step\Acceptance\QuestionnaireMaker $I
     */
    public function addClosedQuestion(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("add an closed question to my questionnaire");
        // And
        $I->click(["id" => "add-check-box-question"]);
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->seeInDatabase("question_closed", [
            "name" => "Untitled",
        ]);
    }

    /**
     * Test to see that the user can successfully add a scaled question to a questionnaire.
     *
     * @param \Step\Acceptance\QuestionnaireMaker $I
     */
    public function addScaledQuestion(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("add an scaled question to my questionnaire");
        // And
        $I->click(["id" => "add-star-rating-question"]);
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->seeInDatabase("question_scaled", [
            "name" => "Untitled",
        ]);
    }
}
