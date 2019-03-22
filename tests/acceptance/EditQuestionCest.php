<?php 

class EditQuestionCest {
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
     * Test to see that changed can be made to specific open question.
     *
     * @param \Step\Acceptance\QuestionnaireMaker $I
     */
    public function editOpenQuestion(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("edit an open question that is added to my questionnaire");
        // And
        $I->click(["id" => "add-single-line-question"]);
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->seeInDatabase("question_open", [
            "name" => "Untitled",
        ]);
        // Then
        $I->moveMouseOver( ".question-answerable");
        // And
        $I->click(["id" => "edit-question"]);
        // And
        $I->fillField("questionOpenName", "First open question");
        // And
        $I->click("Save");
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->see("1. First open question");
        // And
        $I->seeInDatabase("question_open", [
            "name" => "First open question",
        ]);
    }

    /**
     * Test to see that changed can be made to specific closed question.
     *
     * @param \Step\Acceptance\QuestionnaireMaker $I
     */
    public function editClosedQuestion(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("edit a closed question that is added to my questionnaire");
        // And
        $I->click(["id" => "add-drop-down-question"]);
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->seeInDatabase("question_closed", [
            "name" => "Untitled",
        ]);
        // Then
        $I->moveMouseOver( ".question-answerable");
        // And
        $I->click(["id" => "edit-question"]);
        // And
        $I->fillField("questionClosedName", "First closed question");
        // And
        $I->click("Save");
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->see("1. First closed question");
        // And
        $I->seeInDatabase("question_closed", [
            "name" => "First closed question",
        ]);
    }

    /**
     * Test to see that changed can be made to specific scaled question.
     *
     * @param \Step\Acceptance\QuestionnaireMaker $I
     */
    public function editScaledQuestion(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("edit a scaled question that is added to my questionnaire");
        // And
        $I->click(["id" => "add-slider-question"]);
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->seeInDatabase("question_scaled", [
            "name" => "Untitled",
        ]);
        // Then
        $I->moveMouseOver( ".question-answerable");
        // And
        $I->click(["id" => "edit-question"]);
        // And
        $I->fillField("questionScaledName", "First scaled question");
        $I->fillField("questionScaledMax", 10);
        // And
        $I->click("Save");
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->see("1. First scaled question");
        // And
        $I->seeInDatabase("question_scaled", [
            "name" => "First scaled question",
            "max" => 10,
        ]);
    }
}
