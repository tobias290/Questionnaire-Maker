<?php
namespace Step\Api;

class QuestionnaireMaker extends \ApiTester {

    /**
     * Test to see when the user signs up that the API returns the correct response and data.
     */
    public function signUp() {
        $I = $this;

        $I->sendPOST("sign-up", [
            "email" => "tobysx@gmail.com",
            "first_name" => "Toby",
            "surname" => "Essex",
            "password" => "pass1234",
            "confirm_password" => "pass1234",
        ]);
        // Then
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED); // 201
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson([
            "success" => [
                "email" => "tobysx@gmail.com",
                // Also a random access code will be here
            ]
        ]);
    }

    public function login() {
        $I = $this;

        $I->sendPOST("login", [
            "email" => "tobysx@gmail.com",
            "password" => "pass1234",
        ]);
        // Then
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson([
            "success" => [
                "email" => "tobysx@gmail.com",
                // Also a random access code will be here
            ]
        ]);
    }

}