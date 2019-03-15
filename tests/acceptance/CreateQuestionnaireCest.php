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
        $I->click("Create Questionnaire");
        // And
        $I->fillField("title", "First Questionnaire"); // Dashboard button
        $I->fillField("description", "This is the first questionnaire I have made with this website");
        // Then
        $I->click("Create Questionnaire", "submit"); // Form button
        // And
        $I->wait(1);
        // Then
        $I->see("Edit Questionnaire");
        // And
        $I->seeInDatabase("questionnaire", [
            "name" => "First Questionnaire",
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
        // Then
        $I->click("Create Questionnaire", "submit"); // Form Button
        // Then
        $I->see("Title is required");
        // And
        $I->dontSee("Edit Questionnaire");
        // And
        $I->dontSeeInDatabase("questionnaire", [
            "name" => "First Questionnaire",
            "description" => "This is the first questionnaire I have made with this website",
        ]);
    }
}
