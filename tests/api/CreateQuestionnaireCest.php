<?php 

class CreateQuestionnaireCest {
    public function _before(\Step\Api\QuestionnaireMaker $I) {
        $I->login();
    }

    public function createQuestionnaire(ApiTester $I) {
        $I->am("Client Side Application");
        // And
        $I->expectTo("get 201 HTTP code because a questionnaire was created");
        // And
        $I->sendPOST("questionnaire/create", [
            "title" =>"First Questionnaire",
            "description" => "This is the first questionnaire I have made with this website",
        ]);
        // Then
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED); // 401
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseJsonMatchesJsonPath('$.success.questionnaire_id');
    }

    public function createQuestionnaireWithNoTitle(ApiTester $I) {
        $I->am("Client Side Application");
        // And
        $I->expectTo("get 401 HTTP code because the title field is required");
        // And
        $I->sendPOST("questionnaire/create", [
            "description" => "This is the first questionnaire I have made with this website",
        ]);
        // Then
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::UNAUTHORIZED); // 401
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson([
            "error" => [
                "message" => "Title is required",
            ]
        ]);
    }
}
