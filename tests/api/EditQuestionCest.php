<?php 

class EditQuestionCest {
    public function _before(\Step\Api\QuestionnaireMaker $I) {
        $I->signUp();
        // And
        $I->createQuestionnaire();
    }

    /**
     * Test that the correct response is returned when editing a open question.
     *
     * @param \Step\Api\QuestionnaireMaker $I
     */
    public function editOpenQuestion(\Step\Api\QuestionnaireMaker $I) {
        $I->am("Client Side Application");
        // And
        $I->wantTo("edit an open question from a questionnaire");
        // And
        $questionnaire_id = $I->getResponse()["success"]["questionnaire_id"];
        // And
        $I->sendPOST("question/add/open", [
            "position" => 1,
            "questionnaire_id" => $questionnaire_id,
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
        // And
        $question_id = $I->getResponse()["success"]["id"];
        // And
        $I->sendPATCH("question/edit/open/$question_id", [
            "name" => "First open question",
            "is_required" => true,
        ]);
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson([
            "success" => [
                "message" => "Question edited"
            ]
        ]);
    }

    /**
     * Test that the correct response is returned when editing a closed question.
     *
     * @param \Step\Api\QuestionnaireMaker $I
     */
    public function editClosedQuestion(\Step\Api\QuestionnaireMaker $I) {
        $I->am("Client Side Application");
        // And
        $I->wantTo("edit a closed question from a questionnaire");
        // And
        $questionnaire_id = $I->getResponse()["success"]["questionnaire_id"];
        // And
        $I->sendPOST("question/add/closed", [
            "position" => 1,
            "type" => "radio",
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
        // And
        $I->sendPATCH("question/edit/closed/$question_id", [
            "name" => "First closed question",
            "is_required" => true,
        ]);
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson([
            "success" => [
                "message" => "Question edited"
            ]
        ]);
    }

    /**
     * Test that the correct response is returned when editing a scaled question.
     *
     * @param \Step\Api\QuestionnaireMaker $I
     */
    public function editScaledQuestion(\Step\Api\QuestionnaireMaker $I) {
        $I->am("Client Side Application");
        // And
        $I->wantTo("edit a scaled question from a questionnaire");
        // And
        $questionnaire_id = $I->getResponse()["success"]["questionnaire_id"];
        // And
        $I->sendPOST("question/add/scaled", [
            "position" => 1,
            "type" => "star",
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
        // And
        $I->sendPATCH("question/edit/scaled/$question_id", [
            "name" => "First scaled question",
            "is_required" => true,
            "max" => 10,
        ]);
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson([
            "success" => [
                "message" => "Question edited"
            ]
        ]);
    }
}
