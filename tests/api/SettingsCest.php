<?php 

class SettingsCest {
    public function _before(\Step\Api\QuestionnaireMaker $I) {
        $I->signUp();
        // And
        $token = $I->getResponse()["success"]["token"];
        // And
        $I->amBearerAuthenticated($token);
    }

    /**
     * Tests to see that we client can retrieve the user's settings from the API.
     *
     * @param ApiTester $I
     */
    public function getSettings(ApiTester $I) {
        $I->am("Client Side Application");
        // And
        $I->wantTo("get the HTTP 200 response as we have retrieved the users settings");
        // And
        $I->sendGET("user/settings/all");
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        // And
        $I->seeResponseContainsJson();
        // And
        $I->seeResponseJsonMatchesJsonPath("$.user_id");
        // And
        $I->seeResponseJsonMatchesJsonPath("$.enable_in_app_notifications");
        // And
        $I->seeResponseJsonMatchesJsonPath("$.enable_email_notifications");
    }


    /**
     * Tests to see that we client can edit the user's settings.
     *
     * @param ApiTester $I
     */
    public function editSettings(ApiTester $I) {
        $I->am("Client Side Application");
        // And
        $I->wantTo("get the HTTP 200 response as we have edited the users settings");
        // And
        $I->sendPATCH("user/settings/edit", [
            "enable_in_app_notifications" => false,
        ]);
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        // And
        $I->seeResponseContainsJson();
        // And
        $I->seeResponseContainsJson(["success" => [
            "message" => "Settings edited"
        ]]);
    }
}
