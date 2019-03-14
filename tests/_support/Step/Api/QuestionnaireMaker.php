<?php
namespace Step\Api;

use Codeception\Step\Argument\PasswordArgument;

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

    /**
     * Test to see whether the correct response in sent to the client when the user logs in.
     *
     * @param bool $signUp - Run the sign up action. If false the sign up action will not be ran.
     */
    public function login($signUp = true) {
        $I = $this;

        if ($signUp)
            $I->signUp();

        $I->sendPOST("login", [
            "email" => "tobysx@gmail.com",
            "password" => "pass1234",
        ]);
        // Then
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseJsonMatchesJsonPath('$.success.token');
    }

}