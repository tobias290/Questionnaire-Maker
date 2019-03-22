<?php 

class DeleteQuestionCest {
    public function _before(\Step\Api\QuestionnaireMaker $I) {
        $I->signUp();
    }

    /**
     * Test to see whether a question can be deleted or not.
     *
     * @param \Step\Api\QuestionnaireMaker $I
     */
    public function deleteQuestion(\Step\Api\QuestionnaireMaker $I) {
        $I->am("Client Side Application");
        // And
        $I->wantTo("delete a question from a questionnaire");
        // And
        $I->createQuestionnaire();
        // And
        $questionnaire_id = $I->getResponse()["success"]["questionnaire_id"];
        // And
        $I->sendPOST("question/add/open", [
            "position" => 1,
            "is_long" => false,
            "questionnaire_id" => $questionnaire_id,
        ]);
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson([
            "success" => [
                "message" => "Question added"
            ]
        ]);
        // And
        $question_id = $I->getResponse()["success"]["id"];
        // Then
        $I->sendDELETE("question/delete/open/$question_id");
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson([
            "success" => [
                "message" => "Question deleted"
            ]
        ]);
    }

    /**
     * Test to see whether a when trying to delete a random question it refuses.
     *
     * @param \Step\Api\QuestionnaireMaker $I
     */
    public function deleteRandomQuestion(\Step\Api\QuestionnaireMaker $I) {
        $I->am("Client Side Application");
        // And
        $I->expectTo("not be able to delete a random question");
        // And
        $token = $I->getResponse()["success"]["token"];
        // And
        $I->amBearerAuthenticated($token);
        // Then
        $I->sendDELETE("question/delete/open/4");
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::UNAUTHORIZED);
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson([
            "error" => [
                "message" => "You do not own that questionnaire, therefore you cannot delete a question"
            ]
        ]);
    }
}
