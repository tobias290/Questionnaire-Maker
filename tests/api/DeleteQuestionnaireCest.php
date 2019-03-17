<?php 

class DeleteQuestionnaireCest {
    public function _before(\Step\Api\QuestionnaireMaker $I) {
        $I->login();
    }

    /**
     * Test to see when a delete request is send to the server to delete a specific questionnaire that it is removed and a 200 HTTP code is returned with no error.
     *
     * @param \Step\Api\QuestionnaireMaker $I
     */
    public function deleteQuestionnaire(\Step\Api\QuestionnaireMaker $I) {
        $I->am("Client Side Application");
        // And
        $I->expectTo("get 200 HTTP code because see no error because the questionnaire was deleted");
        // And
        $token = $I->getResponse()["success"]["token"];
        // And
        $I->amBearerAuthenticated($token);
        // Then
        $I->createQuestionnaire();
        // And
        $id = $I->getResponse()["success"]["questionnaire_id"];
        // And
        $I->sendDELETE("questionnaire/delete/$id");
        // Then
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 201
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson([
            "success" => [
                "message" => "Questionnaire deleted",
            ]
        ]);
    }
}
