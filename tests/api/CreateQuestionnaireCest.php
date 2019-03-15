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
        $token = $I->getResponse()["success"]["token"];
        // And
        $I->amBearerAuthenticated($token);
        // And
        $I->sendPOST("questionnaire/create", [
            "title" =>"First Questionnaire",
            "description" => "This is the first questionnaire I have made with this website",
            "questionnaire_category_id" => 13,
        ]);
        // Then
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED); // 201
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
        $token = $I->getResponse()["success"]["token"];
        // And
        $I->amBearerAuthenticated($token);
        // And
        $I->sendPOST("questionnaire/create", [
            "description" => "This is the first questionnaire I have made with this website",
            "questionnaire_category_id" => 13,
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

    public function createQuestionnaireWithNoCategory(ApiTester $I) {
        $I->am("Client Side Application");
        // And
        $I->expectTo("get 401 HTTP code because the title field is required");
        // And
        $token = $I->getResponse()["success"]["token"];
        // And
        $I->amBearerAuthenticated($token);
        // And
        $I->sendPOST("questionnaire/create", [
            "title" =>"First Questionnaire",
            "description" => "This is the first questionnaire I have made with this website",
        ]);
        // Then
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::UNAUTHORIZED); // 401
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson([
            "error" => [
                "message" => "Questionnaire Category is required",
            ]
        ]);
    }
}
