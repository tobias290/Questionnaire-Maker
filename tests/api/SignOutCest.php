<?php 

class SignOutCest {
    public function _before(ApiTester $I) {

    }

    /**
     * Test to see when send get request to sign out that it returns HTTP code 200 and a success message.
     *
     * @param ApiTester $I
     */
    public function signOut(\Step\Api\QuestionnaireMaker $I) {
        $I->am("Client Side Application");
        // And
        $I->wantTo("send request to sign out");
        // And
        $I->login();
        // And
        $token = $I->getResponse()["success"]["token"];
        // And
        $I->amBearerAuthenticated($token);
        // Then
        $I->sendGET("user/sign-out");
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        // And
        $I->seeResponseContainsJson([
            "success" => true
        ]);
    }
}
