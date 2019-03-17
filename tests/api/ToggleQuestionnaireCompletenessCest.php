<?php 

class ToggleQuestionnaireCompletenessCest {
    public function _before(\Step\API\QuestionnaireMaker $I) {
        $I->signUp();
        // And
        $I->createQuestionnaire();
    }

    /**
     * Tests to see that when a request is sent to edit the questionnaire that it is successful.
     *
     * @param \Step\API\QuestionnaireMaker $I
     */
    public function markQuestionnaireAsComplete(\Step\API\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("mark my questionnaire as complete");
        // And
        $id = $I->getResponse()["success"]["questionnaire_id"];
        // And
        $I->sendPATCH("questionnaire/edit/$id", [
            "is_complete" => true,
        ]);
        // Then
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson([
            "success" => [
                "message" => "Questionnaire updated",
            ]
        ]);
    }

    /**
     * Tests to see that when a request is sent to edit the questionnaire that it is successful.
     *
     * @param \Step\API\QuestionnaireMaker $I
     */
    public function markQuestionnaireAsIncomplete(\Step\API\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("mark my questionnaire as incomplete");
        // And
        $id = $I->getResponse()["success"]["questionnaire_id"];
        // And
        $I->sendPATCH("questionnaire/edit/$id", [
            "is_complete" => false,
        ]);
        // Then
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
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
