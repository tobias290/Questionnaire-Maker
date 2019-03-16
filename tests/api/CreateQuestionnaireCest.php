<?php 

class CreateQuestionnaireCest {
    public function _before(\Step\Api\QuestionnaireMaker $I) {
        $I->login();
    }

    /**
     * Test to see when the applications submits request to create a questionnaire that it returns 201 HTTP response with no errors.
     *
     * @param \Step\Api\QuestionnaireMaker $I
     */
    public function createQuestionnaire(\Step\Api\QuestionnaireMaker $I) {
        $I->am("Client Side Application");
        // And
        $I->expectTo("get 201 HTTP code because a questionnaire was created");
        // Then
        $I->createQuestionnaire();
    }

    /**
     * Test to see when the applications submits request to create questionnaire that it returns 401 HTTP response with an error because the title is required.
     *
     * @param ApiTester $I
     */
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

    /**
     * Test to see when the applications submits request to create questionnaire that it returns 401 HTTP response with an error because the category is required.
     *
     * @param ApiTester $I
     */
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
