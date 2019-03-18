<?php 

class AddQuestionCest {
    public function _before(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->signUp();
        // And
        $I->amOnFrontEndPage("dashboard");
        // And
        $I->createQuestionnaire();
        // Then
        $I->moveMouseOver( ".questionnaire-list-item");
        // And
        $I->click(["class" => "edit-questionnaire"]);
        // And
        $I->seeInCurrentUrl("edit");
    }

    public function addOpenQuestion(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("add an open question to my questionnaire");
        // And
        $I->click(["id" => "add-single-line-question"]);
        // And
        $I->seeInDatabase("question_open", [
            "name" => "Untitled",
        ]);
    }

    public function addClosedQuestion(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("add an open question to my questionnaire");
        // And
        $I->click(["id" => "add-check-box-question"]);
        // And
        $I->seeInDatabase("question_closed", [
            "name" => "Untitled",
        ]);
    }

    public function addScaledQuestion(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("add an open question to my questionnaire");
        // And
        $I->click(["id" => "add-star-rating-question"]);
        // And
        $I->seeInDatabase("question_open", [
            "name" => "Untitled",
        ]);
    }
}
