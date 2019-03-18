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
    public function editQuestionnaire(AcceptanceTester $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("edit a questionnaire");
        // Then
        $I->moveMouseOver(".questionnaire-list-item");
        // And
        $I->click(["class" => "edit-questionnaire"]);
        // And
        $I->seeInCurrentUrl("edit");
        // And
        $I->click(["id" => "edit-questionnaire"]);
        // And
        $I->see("First Questionnaire"); // Current Title
        // And
        $I->see("This is the first questionnaire I have made with this website"); // Current Description
        // And
        $I->fillField("title", "First Questionnaire Edited");
        $I->fillField("description", "The first questionnaire has been edited.");
        // Then
        $I->click(["id" => "edit-questionnaire-submit"]);
        // And
        $I->wait(1);
        // Then
        $I->see("First Questionnaire Edited");
        // And
        $I->seeInDatabase("questionnaire", [
            "title" => "First Questionnaire Edited",
            "description" => "The first questionnaire has been edited.",
        ]);
    }
}
