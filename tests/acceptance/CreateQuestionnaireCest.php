<?php 

class CreateQuestionnaireCest {
    public function _before(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->signUp();
        $I->amOnFrontEndPage("/dashboard");
    }

    /**
     * Test to see whether the application can successfully create a questionnaire.
     *
     * @param \Step\Acceptance\QuestionnaireMaker $I
     */
    public function createQuestionnaire(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("create a questionnaire");
        // Then
        $I->createQuestionnaire();
    }

    /**
     * Test to see that the application will not create a questionnaire when the title is missing.
     *
     * @param AcceptanceTester $I
     */
    public function createQuestionnaireWithNoTitle(AcceptanceTester $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->expectTo("see an error message saying title is required");
        // Then
        $I->click("Create Questionnaire"); // Dashboard button
        // And
        $I->fillField("description", "This is the first questionnaire I have made with this website");
        $I->selectOption("category", "Other");
        // Then
        $I->click(["id" => "create-questionnaire-submit"]); // Form Button
        // And
        $I->dontSee("Edit Questionnaire");
        // And
        $I->dontSeeInDatabase("questionnaire", [
            "title" => "First Questionnaire",
            "description" => "This is the first questionnaire I have made with this website",
        ]);
    }

    /**
     * Test to see that the application will not create a questionnaire when the category is missing.
     *
     * @param AcceptanceTester $I
     */
    public function createQuestionnaireWithNoCategory(AcceptanceTester $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->expectTo("see an error message saying title is required");
        // Then
        $I->click("Create Questionnaire"); // Dashboard button
        // And
        $I->fillField("title", "First Questionnaire");
        $I->fillField("description", "This is the first questionnaire I have made with this website");
        // Then
        $I->click(["id" => "create-questionnaire-submit"]); // Form Button
        // And
        $I->dontSee("Edit Questionnaire");
        // And
        $I->dontSeeInDatabase("questionnaire", [
            "title" => "First Questionnaire",
            "description" => "This is the first questionnaire I have made with this website",
        ]);
    }
}
