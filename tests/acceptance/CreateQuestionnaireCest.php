<?php 

class CreateQuestionnaireCest {
    public function _before(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->login();
        $I->amOnFrontEndPage("/dashboard");
    }

    public function createQuestionnaire(AcceptanceTester $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("create a questionnaire");
        // Then
        $I->click("Create Questionnaire"); // Dashboard button
        // And
        $I->fillField("title", "First Questionnaire");
        $I->fillField("description", "This is the first questionnaire I have made with this website");
        $I->selectOption("category", "Other");
        // Then
        $I->click(["id" => "create-questionnaire-submit"]); // Form button
        // And
        $I->wait(1);
        // Then
        $I->see("Edit Questionnaire");
        // And
        $I->seeInDatabase("questionnaire", [
            "title" => "First Questionnaire",
            "description" => "This is the first questionnaire I have made with this website",
        ]);
    }

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
