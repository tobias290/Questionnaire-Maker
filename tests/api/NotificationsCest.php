<?php 

class NotificationsCest {
    public function _before(\Step\Api\QuestionnaireMaker $I) {
        $I->signUp();
        // And
        $token = $I->getResponse()["success"]["token"];
        // And
        $I->amBearerAuthenticated($token);
    }

    public function getNotifications(ApiTester $I) {
        $I->am("Client Side Applications");
        // And
        $I->wantTo("get HTTP 200 response as we have retrieved all of the users notifications");
        // And
        $I->sendGET("user/notifications/all");
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        // And
        $I->seeResponseContainsJson();
    }

    public function readAllNotifications(ApiTester $I) {
        $I->am("Client Side Applications");
        // And
        $I->wantTo("get HTTP 200 response as we have read all of the user's notifications");
        // And
        $I->sendPATCH("user/notifications/read-all");
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        // And
        $I->seeResponseContainsJson();
        // And
        $I->seeResponseContainsJson(["success" => [
            "message" => "Notifications read"
        ]]);
    }

    public function deleteAllNotifications(ApiTester $I) {
        $I->am("Client Side Applications");
        // And
        $I->wantTo("get HTTP 200 response as we have deleted all of the users notifications");
        // And
        $I->sendDELETE("user/notifications/delete-all");
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        // And
        $I->seeResponseContainsJson();
        // And
        $I->seeResponseContainsJson(["success" => [
            "message" => "Notifications deleted"
        ]]);
    }

    // NOTE: read one and delete one left out as exact ID is needed
}
