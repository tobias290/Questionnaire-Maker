<?php
namespace Step\Api;

class QuestionnaireMaker extends \ApiTester {

    /**
     * Test to see when the user signs up that the API returns the correct response and data.
     */
    public function signUp() {
        $I = $this;

        $I->sendPOST("user/sign-up", [
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

        $I->sendPOST("user/login", [
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

    /**
     * Test to see when the applications submits request to create a questionnaire that it returns 201 HTTP response with no errors.
     */
    public function createQuestionnaire() {
        $I = $this;

        $token = $I->getResponse()["success"]["token"];
        // And
        $I->amBearerAuthenticated($token);
        // And
        $I->sendPOST("questionnaire/create", [
            "title" =>"First Questionnaire",
            "description" => "This is the first questionnaire I have made with this website",
            "questionnaire_category_id" => 13,
        ]);
        // Then
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED); // 201
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseJsonMatchesJsonPath("$.success.questionnaire_id");
    }

}