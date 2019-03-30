<?php 

class QuestionnaireResponsesCest {
    public function _before(\Step\Api\QuestionnaireMaker $I) {
        $I->signUp();
        // And
        $I->createQuestionnaire();
    }

    public function getResponses(\Step\Api\QuestionnaireMaker $I) {
        $I->am("Client Side Application");
        // And
        $I->wantTo("Get list of the responses from the given questionnaire and get HTTP 200 response");
        // And
        $questionnaire_id = $I->getResponse()["success"]["questionnaire_id"];
        // And
        $I->sendGET("responses/questionnaire/$questionnaire_id/responses");
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseJsonMatchesJsonPath("$.success.questionnaire");
    }

    public function getResponsesWithoutAuthentication(ApiTester $I) {
        $I->am("Client Side Application");
        // And
        $I->expectTo("Get HTTP 401 response as this requests is not authenticated");
        // And
        $I->sendGET("responses/questionnaire/1/responses");
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::UNAUTHORIZED);
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseJsonMatchesJsonPath("$.error");
    }
}
