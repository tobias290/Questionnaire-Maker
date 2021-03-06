<?php 

class ToggleQuestionnaireCompletenessCest {
    public function _before(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->signUp();
        // And
        $I->amOnFrontEndPage("dashboard");
        // And
        $I->createQuestionnaire();
        // And
        $I->amOnFrontEndPage("dashboard");
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
    }

    /**
     * Tests to see when the user clicks the complete button that it makes the questionnaire complete.
     *
     * @param \Step\Acceptance\QuestionnaireMaker $I
     */
    public function markQuestionnaireAsPublic(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("mark my questionnaire as complete");
        // Then
        $I->moveMouseOver( ".questionnaire-list-item");
        // And
        $I->click(["class" => "complete-questionnaire"]);
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->see("Mark Incomplete");
        // And
        $I->seeInDatabase("questionnaire", [
            "title" => "First Questionnaire",
            "description" => "This is the first questionnaire I have made with this website",
            "is_complete" => true,
        ]);
        // And
        $I->click(["class" => "complete-questionnaire"]);
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->see("Mark Complete");
        // And
        $I->seeInDatabase("questionnaire", [
            "title" => "First Questionnaire",
            "description" => "This is the first questionnaire I have made with this website",
            "is_complete" => false,
        ]);
    }
}
