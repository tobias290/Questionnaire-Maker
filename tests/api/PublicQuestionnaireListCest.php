<?php 

class PublicQuestionnaireListCest {
    public function _before(ApiTester $I) {
    }

    /**
     * Test to see that the api returns a list of public questionnaires.
     *
     * @param ApiTester $I
     */
    public function loadList(ApiTester $I) {
        $I->am("Client Side Application");
        // And
        $I->wantTo("get the list of public questionnaires");
        // And
        $I->sendGET("public/questionnaires");
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 201
        // And
        $I->seeResponseIsJson();
    }
}
