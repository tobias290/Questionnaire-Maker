<?php 

class QuestionClosedOptionCest {
    public function _before(\Step\Api\QuestionnaireMaker $I) {
        $I->signUp();
        // Then
        $I->createQuestionnaire();
        // And
        $id = $I->getResponse()["success"]["questionnaire_id"];
        // Then
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

    /**
     * Test to see that a HTTP 201 code is returned when the correct data is send to add an option to a question
     *
     * @param \Step\Api\QuestionnaireMaker $I
     */
    public function addOption(\Step\Api\QuestionnaireMaker $I) {
        $I->am("Client Side Application");
        // And
        $I->wantTo("get the correct response (201) when I send data to add an option to a closed question");
        // Then
        $question_id = $I->getResponse()["success"]["id"];
        // And
        $I->sendPOST("question/add/closed/option", [
            "option" => "Option 1",
            "question_closed_id" => $question_id,
        ]);
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson([
            "success" => [
                "message" => "Question option added"
            ]
        ]);
    }

    /**
     * Test to see that a HTTP 201 code is returned when the correct data is send to edit an option on a question
     *
     * @param \Step\Api\QuestionnaireMaker $I
     */
    public function editOption(\Step\Api\QuestionnaireMaker $I) {
        $I->am("Client Side Application");
        // And
        $I->wantTo("get the correct response (201) when I send data to edit an option on a closed question");
        // Then
        $question_id = $I->getResponse()["success"]["id"];
        // And
        $I->sendPOST("question/add/closed/option", [
            "option" => "Option 1",
            "question_closed_id" => $question_id,
        ]);
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson([
            "success" => [
                "message" => "Question option added"
            ]
        ]);
        // Then
        $option_id = $I->getResponse()["success"]["id"];
        // And
        $I->sendPATCH("question/edit/closed/option/$option_id", [
            "option" => "New Option 1",
        ]);
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson([
            "success" => [
                "message" => "Question option edited"
            ]
        ]);
    }

    /**
     * Test to see that a HTTP 201 code is returned when the correct data is send to delete an option from a question
     *
     * @param \Step\Api\QuestionnaireMaker $I
     */
    public function deleteOption(\Step\Api\QuestionnaireMaker $I) {
        $I->am("Client Side Application");
        // And
        $I->wantTo("get the correct response (201) when I send data to delete an option from a closed question");
        // Then
        $question_id = $I->getResponse()["success"]["id"];
        // And
        $I->sendPOST("question/add/closed/option", [
            "option" => "Option 1",
            "question_closed_id" => $question_id,
        ]);
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson([
            "success" => [
                "message" => "Question option added"
            ]
        ]);
        // Then
        $option_id = $I->getResponse()["success"]["id"];
        // And
        $I->sendDELETE("question/delete/closed/option/$option_id");
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson([
            "success" => [
                "message" => "Question option deleted"
            ]
        ]);
    }
}
