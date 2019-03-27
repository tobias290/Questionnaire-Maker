<?php 

class AnswerQuestionnaireCest {
    public function _before(ApiTester $I) {
        // Database will already have a pre-loaded questionnaire ready to answer
    }

    public function submitQuestionnaire(ApiTester $I) {
        $I->am("Client Side Application");
        // And
        $I->wantTo("send responses to a questionnaire and get a HTTP 201 response");
        // And
        $id = 25;
        // And
        $I->sendPOST("public/questionnaire/$id/answer", [
            "open" => [
               [ // Single line question
                   "id" => 1,
                   "response" => "This is a random response to this question",
               ],
            ],
            "closed" => [
                [
                    "options" => [ // Drop down question
                        5,
                    ],
                ],
                [
                    "options" => [ // Multiple choice, therefore multiple answers can be submitted,
                        1,
                        3,
                    ],
                ],
            ],
            "scaled" => [
                [ // Star question
                    "id" => 1,
                    "response" => 4,
                ]
            ],
        ]);
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson(["success" => [
            "message" => "Response saved",
        ]]);
    }

    public function submitQuestionnaireWithRequiredQuestionMissing(ApiTester $I) {
        $I->am("Client Side Application");
        // And
        $I->expectTo("get HTTP 401 error as required question was missing");
        // And
        $id = 25;
        // And
        $I->sendPOST("public/questionnaire/$id/answer", [
            "open" => [ // NOTE: left out as it is required
//                [ // Single line question
//                    "id" => 1,
//                    "response" => "This is a random response to this question",
//                ],
            ],
            "closed" => [
                [
                    "options" => [ // Drop down question
                        5,
                    ],
                ],
                [
                    "options" => [ // Multiple choice, therefore multiple answers can be submitted,
                        1,
                        3,
                    ],
                ],
            ],
            "scaled" => [
                [ // Star question
                    "id" => 1,
                    "response" => 4,
                ]
            ],
        ]);
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST); // 400
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson(["error" => [
            "message" => "Required questions are missing",
        ]]);
    }
}
