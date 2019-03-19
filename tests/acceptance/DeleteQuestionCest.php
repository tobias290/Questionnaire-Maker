<?php 

class DeleteQuestionCest {
    public function _before(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->signUp();
        // And
        $I->amOnFrontEndPage("dashboard");
        // And
        $I->createQuestionnaire();
        // And
        $I->seeInCurrentUrl("edit");
    }


    public function deleteQuestion(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("delete a question from a questionnaire");
        // Then
        $I->click(["id" => "add-single-line-question"]);
        // And
        $I->wait(1);
        // And
        $I->seeInDatabase("question_open", [
            "name" => "Untitled",
        ]);
        // Then
        $I->moveMouseOver( ".question-answerable");
        // And
        $I->click(["id" => "delete-question"]);
        // And
        $I->dontSeeInDatabase("question_open", [
            "name" => "Untitled",
        ]);
    }
}
