<?php 

class DuplicateQuestionCest {
    public function _before(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->signUp();
        // And
        $I->amOnFrontEndPage("dashboard");
        // And
        $I->createQuestionnaire();
        // And
        $I->seeInCurrentUrl("edit");
    }

    public function duplicateOpenQuestion(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("duplicate an open question");
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
        $I->click(["id" => "duplicate-question"]);
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->seeNumRecords(2, "question_open", ["name" => "Untitled"]);
    }

    public function duplicateClosedQuestion(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("duplicate a closed question");
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
        $I->click(["id" => "duplicate-question"]);
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->seeNumRecords(2, "question_closed", ["name" => "Untitled"]);
    }

    public function duplicateScaledQuestion(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("duplicate a scaled question");
        // And
        $I->click(["id" => "add-star-rating-question"]);
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->seeInDatabase("question_scaled", [
            "name" => "Untitled",
        ]);
        // Then
        $I->moveMouseOver( ".question-answerable");
        // And
        $I->click(["id" => "duplicate-question"]);
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->seeNumRecords(2, "question_scaled", ["name" => "Untitled"]);
    }
}
