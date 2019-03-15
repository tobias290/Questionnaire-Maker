<?php 

class DashboardCest {
    public function _before(\Step\Api\QuestionnaireMaker $I) {
    }

    /**
     * Test to see when I request details for dashboard after logging in that the correct user details are returned.
     *
     * @param \Step\Api\QuestionnaireMaker $I
     */
    public function viewDashboard(\Step\Api\QuestionnaireMaker $I) {
        $I->am("Client Side Application");
        // And
        $I->wantTo("get user details to help display data in the dashboard");
        // Then
        $I->login();
        // And
        $token = $I->getResponse()["success"]["token"];
        // And
        $I->amBearerAuthenticated($token);
        // Then
        $I->sendGET("details");
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        // And
        $I->seeResponseContainsJson([
            "email" => "tobysx@gmail.com",
            "first_name" => "Toby",
            "surname" => "Essex",
        ]);
    }

    /**
     * Test to see when I request user details for dashboard without logging in that I get a HTTP 401 error and do not get any user details.
     *
     * @param \Step\Api\QuestionnaireMaker $I
     */
    public function viewDashboardWithoutLoggingIn(\Step\Api\QuestionnaireMaker $I) {
        $I->am("Client Side Application");
        // And
        $I->expectTo("get HTTP 401 error because the request in unauthorized");
        // Then
        $I->sendGET("details");
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::UNAUTHORIZED);
        // And
        $I->dontSeeResponseJsonMatchesJsonPath('$.success.user');
    }
}
