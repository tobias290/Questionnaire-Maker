<?php 

class AnswerQuestionnaireCest {
    public function _before(AcceptanceTester $I) {
        // Database will already have a pre-loaded questionnaire ready to answer

        // Check required content is in the database
        $I->seeInDatabase("questionnaire", [
            "id" => 1,
            "name" => "Public Questionnaire",
            "is_public" => true,
            "is_complete" => true,
        ]);
        $I->seeInDatabase("question_open", [
            "id" => 1,
            "name" => "Single Line Question",
            "is_required" => true,
            "is_long" => false,
            "questionnaire_id" => 1,
        ]);
        $I->seeInDatabase("question_scaled", [
            "id" => 1,
            "name" => "Star rating question",
            "is_required" => false,
            "min" => 0,
            "max" => 5,
            "interval" => 1,
            "questionnaire_id" => 1,

        ]);
        $I->seeInDatabase("question_closed", [
            "id" => 1,
            "name" => "Allow multiple options",
            "is_required" => false,
            "type" => "radio",
            "questionnaire_id" => 1,
        ]);
        $I->seeInDatabase("question_closed", [
            "id" => 2,
            "name" => "Drop down question",
            "is_required" => false,
            "type" => "drop_down",
            "questionnaire_id" => 1,
        ]);
        $I->seeNumRecords(7, "question_closed_option");
    }

    public function submitQuestionnaire(AcceptanceTester $I) {
        $I->am("Respondent");
        // And
        $I->wantTo("answer a questionnaire to help a questionnaire maker");
        // And
        $I->amOnFrontEndPage("public/questionnaires");
        // And
        $I->see("Public Questionnaires");
        // And
        $I->click(["class" => "questionnaire-list-item"]);
        // And
        $I->click("Take Questionnaire");
        // And
        $I->seeInCurrentUrl("public/questionnaires/1/answer");
        // And
        $I->see("Public Questionnaire");
        // And
        // TODO: Click star button
        // And
        // TODO: I click radio button
        // And
        // TODO: I select drop down element
        // And
        // TODO: I fill input field
        // And
        $I->click("Submit");
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->see("Thank you for taking this questionnaire!");
    }

    public function submitQuestionnaireWithRequiredQuestionMissing(AcceptanceTester $I) {
        $I->am("Respondent");
        // And
        $I->wantTo("answer a questionnaire to help a questionnaire maker");
        // And
        $I->amOnFrontEndPage("public/questionnaires");
        // And
        $I->see("Public Questionnaires");
        // And
        $I->click(["class" => "questionnaire-list-item"]);
        // And
        $I->click("Take Questionnaire");
        // And
        $I->seeInCurrentUrl("public/questionnaires/1/answer");
        // And
        $I->see("Public Questionnaire");
        // And
        // TODO: Click star button
        // And
        // TODO: I DO NOT click radio button
        // And
        // TODO: I select drop down element
        // And
        // TODO: I fill input field
        // And
        $I->click("Submit");
        // And
        $I->wait(AcceptanceTester::WAIT_TIME);
        // And
        $I->dontSee("Thank you for taking this questionnaire!");
    }

    public function cancelQuestionnaire(AcceptanceTester $I) {
        $I->am("Respondent");
        // And
        $I->wantTo("answer a questionnaire to help a questionnaire maker");
        // And
        $I->amOnFrontEndPage("public/questionnaires");
        // And
        $I->click(["class" => "questionnaire-list-item"]);
        // And
        $I->seeInCurrentUrl("public/questionnaires/1/answer");
        // And
        $I->see("Public Questionnaire");
        // And
        $I->click("Cancel");
        // And
        $I->seeInCurrentUrl("public/questionnaires");
    }
}
