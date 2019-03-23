<?php 

class QuestionClosedOptionCest {
    public function _before(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->signUp();
        // And
        $I->amOnFrontEndPage("dashboard");
        // And
        $I->createQuestionnaire();
        // And
        $I->seeInCurrentUrl("edit");
        // And
        $I->click(["id" => "add-check-box-question"]);
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
    }

    /**
     * Tests to see that an option can be added to a closed question/
     *
     * @param \Step\Acceptance\QuestionnaireMaker $I
     */
    public function addOption(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("add an option to one of my closed questions");
        // Then
        $I->click(["class" => "add-question-option"]);
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->click("Save");
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->seeInDatabase("question_closed_option", [
            "option" => "Untitled",
        ]);
    }

    /**
     * Tests to see that an option can be edited on a closed question
     *
     * @param \Step\Acceptance\QuestionnaireMaker $I
     */
    public function editOption(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("edit an option to one of my closed questions");
        // Then
        $I->click(["class" => "add-question-option"]);
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->click("Save");
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->seeInDatabase("question_closed_option", [
            "option" => "Untitled",
        ]);
        // Then
        $I->moveMouseOver( ".question-answerable");
        // And
        $I->click(["id" => "edit-question"]);
        // And
        $I->fillField("option_1", "New Option");
        // And
        $I->click("Save");
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->seeInDatabase("question_closed_option", [
            "option" => "New Option",
        ]);
    }

    /**
     * Tests to see that an option can be delete from a closed question
     *
     * @param \Step\Acceptance\QuestionnaireMaker $I
     */
    public function deleteOption(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("delete an option to one of my closed questions");
        // Then
        $I->click(["class" => "add-question-option"]);
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->click("Save");
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->seeInDatabase("question_closed_option", [
            "option" => "Untitled",
        ]);
        // Then
        $I->moveMouseOver( ".question-answerable");
        // And
        $I->click(["id" => "edit-question"]);
        // And
        $I->click(["class" => "delete-question-option"]);
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->click("Save");
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->dontSeeInDatabase("question_closed_option", [
            "option" => "Untitled",
        ]);
    }
}
