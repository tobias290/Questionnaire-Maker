<?php 

class AccountCest {
    public function _before(\Step\Api\QuestionnaireMaker $I) {
        $I->signUp();
        // And
        $token = $I->getResponse()["success"]["token"];
        // And
        $I->amBearerAuthenticated($token);
    }

    /**
     * Tests to see that the API returns the users details.
     *
     * @param ApiTester $I
     */
    public function getDetails(ApiTester $I) {
        $I->am("Client Side Application");
        // And
        $I->expectTo("get HTTP 200 response because we got the users details successfully");
        // Then
        $I->sendGET("user/details");
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson([
            "email" => "tobysx@gmail.com",
            "first_name" => "Toby",
            "surname" => "Essex",
        ]);
    }

    /**
     * Tests to see the API successfully edits the users first/last name.
     *
     * @param ApiTester $I
     */
    public function changeName(ApiTester $I) {
        $I->am("Client Side Application");
        // And
        $I->expectTo("get HTTP 200 response because we changed the users name successfully");
        // Then
        $I->sendPOST("user/edit", [
            "first_name" => "Tobey",
            "surname" => "Newham"
        ]);
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson(["success" => [
            "message" => "Account details edited"
        ]]);
    }

    /**
     * Tests to see the API successfully edits the users email.
     *
     * @param ApiTester $I
     */
    public function changeEmail(ApiTester $I) {
        $I->am("Client Side Application");
        // And
        $I->expectTo("get HTTP 200 response because we changed the email name successfully");
        // Then
        $I->sendPOST("user/edit", [
            "email" => "toby@sxhome.co.uk",
            "current_password" => "pass1234"
        ]);
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson(["success" => [
            "message" => "Account details edited"
        ]]);
    }

    /**
     * Tests to see the API successfully returns error as the current password is incorrect.
     *
     * @param ApiTester $I
     */
    public function changeEmailWithIncorrectPassword(ApiTester $I) {
        $I->am("Client Side Application");
        // And
        $I->expectTo("get HTTP 401 response the current password is incorrect");
        // Then
        $I->sendPOST("user/edit", [
            "email" => "toby@sxhome.co.uk",
            "current_password" => "incorrect_password"
        ]);
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::UNAUTHORIZED);
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson(["error" => [
            "message" => "Current password is incorrect"
        ]]);
    }

    /**
     * Tests to see the API successfully returns error when the current password is missing.
     *
     * @param ApiTester $I
     */
    public function changeEmailWithCurrentPasswordMissing(ApiTester $I) {
        $I->am("Client Side Application");
        // And
        $I->expectTo("get HTTP 401 response the current password is missing");
        // Then
        $I->sendPOST("user/edit", [
            "email" => "toby@sxhome.co.uk",
        ]);
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::UNAUTHORIZED);
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson(["error" => [
            "message" => "Current password is required to update these account details"
        ]]);
    }

    /**
     * Tests to see the API successfully changes the users password.
     *
     * @param ApiTester $I
     */
    public function changePassword(ApiTester $I) {
        $I->am("Client Side Application");
        // And
        $I->expectTo("get HTTP 200 response because we changed the password name successfully");
        // Then
        $I->sendPOST("user/edit", [
            "password" => "password",
            "current_password" => "pass1234"
        ]);
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson(["success" => [
            "message" => "Account details edited"
        ]]);
    }

    /**
     * Tests to see the API successfully returns error as the current password is incorrect.
     *
     * @param ApiTester $I
     */
    public function changePasswordWithIncorrectPassword(ApiTester $I) {
        $I->am("Client Side Application");
        // And
        $I->expectTo("get HTTP 401 response because the current password is incorrect");
        // Then
        $I->sendPOST("user/edit", [
            "password" => "password",
            "current_password" => "incorrect_password"
        ]);
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::UNAUTHORIZED);
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson(["error" => [
            "message" => "Current password is incorrect"
        ]]);
    }

    /**
     * Tests to see the API successfully returns error as the current password is missing.
     *
     * @param ApiTester $I
     */
    public function changePasswordWithCurrentPasswordMissing(ApiTester $I) {
        $I->am("Client Side Application");
        // And
        $I->expectTo("get HTTP 401 response because the current password is missing");
        // Then
        $I->sendPOST("user/edit", [
            "password" => "password",
        ]);
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::UNAUTHORIZED);
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson(["error" => [
            "message" => "Current password is required to update these account details"
        ]]);
    }

    /**
     * Test to see that the API successfully deletes the user's account.
     *
     * @param ApiTester $I
     */
    public function deleteAccount(ApiTester $I) {
        $I->am("Client Side Application");
        // And
        $I->expectTo("get HTTP 200 response because we successfully deleted the account");
        // Then
        $I->sendDELETE("user/delete", [
            "current_password" => "pass1234"
        ]);
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson(["success" => [
            "message" => "Account deleted"
        ]]);
    }

    /**
     * Tests to see the API successfully returns error as the current password is incorrect.
     *
     * @param ApiTester $I
     */
    public function deleteAccountWithIncorrectCurrentPassword(ApiTester $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->expectTo("get HTTP 401 response because the current password is incorrect");
        // Then
        $I->sendDELETE("user/delete", [
            "current_password" => "incorrect_password"
        ]);
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::UNAUTHORIZED);
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson(["error" => [
            "message" => "Current password is incorrect"
        ]]);
    }

    /**
     * Tests to see the API successfully returns error as the current password is missing.
     *
     * @param ApiTester $I
     */
    public function deleteAccountWithCurrentPasswordMissing(ApiTester $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->expectTo("get HTTP 401 response because the current password is missing");
        // Then
        $I->sendDELETE("user/delete", []);
        // And
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::UNAUTHORIZED);
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson(["error" => [
            "message" => "Current password is required"
        ]]);
    }
}
