<?php
namespace Step\Api;

class QuestionnaireMaker extends \ApiTester {

    /**
     * Test to see when the user signs up that the API returns the correct response and data.
     */
    public function signUp() {
        $I = $this;

        $I->am("Client Side Application");
        // And
        $I->wantTo("send sign up data to server and successfully sign up");
        // And
        $I->sendPOST("api/sign-up", [
            "email" => "tobiascompany@gmail.com",
            "first_name" => "Toby",
            "surname" => "Essex",
            "password" => "pass1234",
            "confirm_password" => "pass1234",
        ]);
        // Then
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson([
            "success" => [
                "email" => "tobiascompany@gmail.com",
            ]
        ]);
    }

    public function login() {
        $I = $this;
    }

}