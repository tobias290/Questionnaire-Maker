<?php

class LogInCest {
    public function _before(ApiTester $I) {
    }

    protected function loginProvider() {
        return [
            [
                "field" => "email",
                "value" => "tobysx@gmail.com",
                "message" => "Password is required",
            ],
            [
                "field" => "password",
                "value" => "pass1234",
                "message" => "Email is required",
            ],
        ];
    }

    public function login(\Step\Api\QuestionnaireMaker $I) {
        $I->am("Client Side Application");
        // And
        $I->wantTo("send login data to server and successfully login");
        // And
        $I->login();
    }

    /**
     * Test to see when an incorrect email is given the server response with error message
     *
     * @param ApiTester $I
     */
    public function loginWithIncorrectEmail(\Step\Api\QuestionnaireMaker $I) {
        $I->am("Client Side Application");
        // And
        $I->expectTo("get HTTP 401 error because the email is incorrect");
        // And
        $I->signUp();
        // And
        $I->sendPOST("login", [
            "email" => "incorrect@email.com",
            "password" => "pass1234",
        ]);
        // Then
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::UNAUTHORIZED); // 401
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson([
            "error" => [
                "message" => "Email or password is incorrect",
            ]
        ]);
    }

    /**
     * Test to see when an incorrect password is given the server response with error message
     *
     * @param ApiTester $I
     */
    public function loginWithIncorrectPassword(\Step\Api\QuestionnaireMaker $I) {
        $I->am("Client Side Application");
        // And
        $I->expectTo("get HTTP 401 error because the password is incorrect");
        // And
        $I->signUp();
        // And
        $I->sendPOST("login", [
            "email" => "tobysx@gmail.com",
            "password" => "incorrect_password",
        ]);
        // Then
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::UNAUTHORIZED); // 401
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson([
            "error" => [
                "message" => "Email or password is incorrect",
            ]
        ]);
    }

    /**
     * Test to see when a specific field is left empty that the correct error is raised and correct message is shown.
     *
     * @param ApiTester $I
     * @param \Codeception\Example $example
     *
     * @dataProvider loginProvider
     */
    public function loginWithMissingData(\Step\Api\QuestionnaireMaker $I, \Codeception\Example $example) {
        $I->am("Client Side Application");
        // And
        $I->expectTo("get HTTP 401 error because a input field is missing");
        // And
        $I->signUp();
        // And
        $I->sendPOST("login", [$example["field"] => $example["value"],]);
        // Then
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::UNAUTHORIZED); // 401
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson([
            "error" => [
                "message" => $example["message"],
            ]
        ]);
    }
}
