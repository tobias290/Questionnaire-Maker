<?php 

class DuplicateQuestionCest {
    public function _before(\Step\Api\QuestionnaireMaker $I) {
        $I->signUp();
        // And
        $I->createQuestionnaire();
    }

    /**
     * Tests to see that the correct response it returned when asked to duplicate an open question.
     *
     * @param \Step\Api\QuestionnaireMaker $I
     */
    public function duplicateOpenQuestion(\Step\Api\QuestionnaireMaker $I) {
        $I->am("Client Side Application");
        // And
        $I->wantTo("get 201 HTTP code because an open question is duplicated");
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
        // And
        $question_id = $I->getResponse()["success"]["id"];
        // And
        $I->sendPOST("question/duplicate/open", [
            "position" => 2,
            "question_id" => $question_id,
        ]);
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson([
            "success" => [
                "message" => "Question duplicated"
            ]
        ]);
    }

    /**
     * Tests to see that the correct response it returned when asked to duplicate a closed question.
     *
     * @param \Step\Api\QuestionnaireMaker $I
     */
    public function duplicateClosedQuestion(\Step\Api\QuestionnaireMaker $I) {
        $I->am("Client Side Application");
        // And
        $I->wantTo("get 201 HTTP code because a closed question is duplicated");
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
        // And
        $question_id = $I->getResponse()["success"]["id"];
        // And
        $I->sendPOST("question/duplicate/closed", [
            "position" => 2,
            "question_id" => $question_id,
        ]);
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson([
            "success" => [
                "message" => "Question duplicated"
            ]
        ]);
    }

    /**
     * Tests to see that the correct response it returned when asked to duplicate a scaled question.
     *
     * @param \Step\Api\QuestionnaireMaker $I
     */
    public function duplicateScaledQuestion(\Step\Api\QuestionnaireMaker $I) {
        $I->am("Client Side Application");
        // And
        $I->wantTo("get 201 HTTP code because a scaled question is duplicated");
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
        // And
        $question_id = $I->getResponse()["success"]["id"];
        // And
        $I->sendPOST("question/duplicate/scaled", [
            "position" => 2,
            "question_id" => $question_id,
        ]);
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson([
            "success" => [
                "message" => "Question duplicated"
            ]
        ]);
    }
}
