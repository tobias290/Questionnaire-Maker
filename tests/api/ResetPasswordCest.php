<?php 

class ResetPasswordCest {
    public function _before(ApiTester $I) {
    }

    public function resetPassword(ApiTester $I) {
        $I->am("Client Side Application");
        // And
        $I->wantTo("reset the user's password");
        // And
        $I->sendPOST("user/forgotten-password", [
            "email" => "tobysx@gmail.com"
        ]);
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        // And
        $I->seeResponseContainsJson();
        // And
        $I->seeResponseContainsJson(["success" => [
            "message" => "Email sent"
        ]]);
    }

    public function resetPasswordWithIncorrectPassword(ApiTester $I) {
        $I->am("Client Side Application");
        // And
        $I->wantTo("reset the user's password");
        // And
        $I->sendPOST("user/forgotten-password", [
            "email" => "not_in_database"
        ]);
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST);
        // And
        $I->seeResponseContainsJson();
        // And
        $I->seeResponseContainsJson(["error" => [
            "message" => "Incorrect email"
        ]]);
    }
}
