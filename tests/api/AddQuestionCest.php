<?php 

class AddQuestionCest {
    public function _before(\Step\Api\QuestionnaireMaker $I) {
        $I->signUp();
        // And
        $I->createQuestionnaire();
    }

    public function addOpenQuestion(\Step\Api\QuestionnaireMaker $I) {
        $I->am("Client Side Application");
        // And
        $I->wantTo("add a question to a questionnaire");
        // And
        $id = $I->getResponse()["success"]["questionnaire_id"];
        // And
        $I->sendPOST("question/add/open", [
            "position" => 1,
            "questionnaire_id" => $id,
            "is_long" => false,
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
    }

    public function addClosedQuestion(\Step\Api\QuestionnaireMaker $I) {
        $I->am("Client Side Application");
        // And
        $I->wantTo("add a question to a questionnaire");
        // And
        $id = $I->getResponse()["success"]["questionnaire_id"];
        // And
        $I->sendPOST("question/add/closed", [
            "position" => 1,
            "type" => "radio",
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
    }

    public function addScaledQuestion(\Step\Api\QuestionnaireMaker $I) {
        $I->am("Client Side Application");
        // And
        $I->wantTo("add a question to a questionnaire");
        // And
        $id = $I->getResponse()["success"]["questionnaire_id"];
        // And
        $I->sendPOST("question/add/scaled", [
            "position" => 1,
            "type" => "star",
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
    }
}
