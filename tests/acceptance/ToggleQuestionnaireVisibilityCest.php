<?php 

class ToggleQuestionnaireVisibilityCest {
    public function _before(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->signUp();
        // And
        $I->amOnFrontEndPage("dashboard");
        // And
        $I->createQuestionnaire();
    }

    /**
     * Tests to see when the user clicks the public button that it makes the questionnaire public.
     *
     * @param \Step\Acceptance\QuestionnaireMaker $I
     */
    public function markQuestionnaireAsPublic(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("mark my questionnaire as public");
        // And
        $I->click(["class" => "mark-questionnaire-as-public"]);
        // And
        $I->see("Make Private");
        // And
        $I->seeInDatabase("questionnaire", [
            "title" => "First Questionnaire",
            "description" => "This is the first questionnaire I have made with this website",
            "is_public" => true,
        ]);
    }

    /**
     * Tests to see when the user clicks the public button that it makes the questionnaire private. (As it is already public)
     *
     * @param \Step\Acceptance\QuestionnaireMaker $I
     */
    public function markQuestionnaireAsPrivate(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("mark my questionnaire as private");
        // And
        $I->click(["class" => "mark-questionnaire-as-public"]);
        // And
        $I->see("Make Public");
        // And
        $I->seeInDatabase("questionnaire", [
            "title" => "First Questionnaire",
            "description" => "This is the first questionnaire I have made with this website",
            "is_public" => false,
        ]);
    }
}
