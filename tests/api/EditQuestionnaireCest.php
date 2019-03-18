<?php 

class EditQuestionnaireCest {
    public function _before(\Step\Api\QuestionnaireMaker $I) {
        $I->login();
        // Then
        $token = $I->getResponse()["success"]["token"];
        // And
        $I->amBearerAuthenticated($token);
        // Then
        $I->createQuestionnaire();
    }

    /**
     * Test to see when the applications submits request to edit a questionnaire that it is successful.
     *
     * @param ApiTester $I
     */
    public function editQuestionnaire(ApiTester $I) {
        $I->am("Client Side Application");
        // And
        $I->expectTo("get 201 HTTP code because a questionnaire was edited");
        // Then
        $id = $I->getResponse()["success"]["questionnaire_id"];
        // And
        $I->sendPATCH("questionnaire/edit/$id", [
            "title" =>"First Questionnaire Edited",
            "description" => "The first questionnaire has been edited.",
        ]);
        // Then
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 201
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson([
            "success" => [
                "message" => "Questionnaire updated",
            ]
        ]);
    }
}
