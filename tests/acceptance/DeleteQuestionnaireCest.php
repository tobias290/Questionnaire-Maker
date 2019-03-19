<?php 

class DeleteQuestionnaireCest {
    public function _before(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->signUp();
        // And
        $I->amOnFrontEndPage("dashboard");
    }

    /**
     * Test to see when the application will delete a questionnaire and that it is no longer in the database.
     *
     * @param \Step\Acceptance\QuestionnaireMaker $I
     */
    public function deleteQuestionnaire(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("delete a questionnaire I created");
        // Then
        $I->createQuestionnaire();
        // And
        $I->amOnFrontEndPage("dashboard");
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // Then
        $I->moveMouseOver( ".questionnaire-list-item");
        // And
        $I->click(["class" => "delete-questionnaire"]);
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->dontSee("First Questionnaire");
        // And
        $I->dontSeeInDatabase("questionnaire", [
            "title" => "First Questionnaire",
            "description" => "This is the first questionnaire I have made with this website"
        ]);
    }
}
