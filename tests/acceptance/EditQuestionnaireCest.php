<?php 

class EditQuestionnaireCest {
    public function _before(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->signUp();
        $I->amOnFrontEndPage("/dashboard");
    }

    /**
     * Test to see that I can successfully edit a questionnaire.
     *
     * @param AcceptanceTester $I
     */
    public function editQuestionnaire(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("edit a questionnaire");
        // And
        $I->createQuestionnaire();
        // And
        $I->seeInCurrentUrl("edit");
        // Then
        $I->moveMouseOver( ".questionnaire-list-item");
        // And
        $I->click(["class" => "edit-questionnaire"]);
        // And
        $I->see("First Questionnaire"); // Current Title
        // And
        $I->fillField("title", "First Questionnaire Edited");
        $I->fillField("description", "The first questionnaire has been edited.");
        // Then
        $I->click(["id" => "create-questionnaire-submit"]);
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // Then
        $I->see("First Questionnaire Edited");
        // And
        $I->seeInDatabase("questionnaire", [
            "title" => "First Questionnaire Edited",
            "description" => "The first questionnaire has been edited.",
        ]);
    }
}
