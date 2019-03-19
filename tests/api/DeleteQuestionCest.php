<?php 

class DeleteQuestionCest {
    public function _before(\Step\Api\QuestionnaireMaker $I) {
        $I->signUp();
        // And
        $I->createQuestionnaire();
    }

    public function deleteQuestion(\Step\Api\QuestionnaireMaker $I) {
        $I->am("Client Side Application");
        // And
        $I->wantTo("delete a question from a questionnaire");
        // And
        $id = $I->getResponse()["success"]["questionnaire_id"];
        // And
        $I->sendPOST("question/add/open", [
            "position" => 1,
            "is_long" => false,
            "questionnaire_id" => $id,
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
        // Then
        $I->sendDELETE("question/delete/open/1");
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
}
