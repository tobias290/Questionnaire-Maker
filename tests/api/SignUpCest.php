<?php 

class SignUpCest {
    public function _before(ApiTester $I) {
    }

    protected function signUpProvider() {
        return [
            [
               "data" => [
                   "first_name" => "Toby",
                   "surname" => "Essex",
                   "password" => "pass1234",
                   "confirm_password" => "pass1234",
               ],
               "json_contains" => [
                   "error" => [
                       "email" => ["Email is required"]
                   ]
               ],
            ],
            [
                "data" => [
                    "email" => "tobiascompany@gmail.com",
                    "surname" => "Essex",
                    "password" => "pass1234",
                    "confirm_password" => "pass1234",
                ],
                "json_contains" => [
                    "error" => [
                        "first_name" => ["First Name is required"]
                    ]
                ],
            ],
            [
                "data" => [
                    "email" => "tobiascompany@gmail.com",
                    "first_name" => "Toby",
                    "password" => "pass1234",
                    "confirm_password" => "pass1234",
                ],
                "json_contains" => [
                    "error" => [
                        "surname" => ["Surname is required"]
                    ]
                ],
            ],
            [
                "data" => [
                    "email" => "tobiascompany@gmail.com",
                    "first_name" => "Toby",
                    "surname" => "Essex",
                    "confirm_password" => "pass1234",
                ],
                "json_contains" => [
                    "error" => [
                        "password" => ["Password is required"]
                    ]
                ],
            ],
            [
                "data" => [
                    "email" => "tobiascompany@gmail.com",
                    "first_name" => "Toby",
                    "surname" => "Essex",
                    "password" => "pass1234",
                ],
                "json_contains" => [
                    "error" => [
                        "confirm_password" => ["Confirm Password is required"]
                    ]
                ],
            ],
        ];
    }

    /**
     * Test to see when the user signs up that the API returns the correct response and data.
     *
     * @param \Step\Api\QuestionnaireMaker $I
     */
    public function signUp(\Step\Api\QuestionnaireMaker $I) {
        $I->signUp();
    }

    /**
     * Test to see when the user signs up with un-matching passwords that the API returns the correct response and data.
     *
     * @param ApiTester $I
     */
    public function signUpWithUnMatchingPasswords(ApiTester $I) {
        $I->am("Client Side Application");
        // And
        $I->expectTo("get HTTP 401 error because the passwords do not match");
        // And
        $I->sendPOST("sign-up", [
            "email" => "tobiascompany@gmail.com",
            "first_name" => "Toby",
            "surname" => "Essex",
            "password" => "pass1234",
            "confirm_password" => "password",
        ]);
        // Then
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::UNAUTHORIZED); // 401
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson([
            "error" => [
                "confirm_password" => ["Passwords do not match"],
            ]
        ]);
    }

    /**
     * Test to see when the user signs up with an invalid email that the API returns the correct response and data.
     *
     * @param ApiTester $I
     */
    public function signUpWithInvalidEmail(ApiTester $I) {
        $I->am("Client Side Application");
        // And
        $I->expectTo("get HTTP 401 error because the email is invalid");
        // And
        $I->sendPOST("sign-up", [
            "email" => "not_valid_email",
            "first_name" => "Toby",
            "surname" => "Essex",
            "password" => "pass1234",
            "confirm_password" => "pass1234",
        ]);
        // Then
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::UNAUTHORIZED); // 401
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson([
            "error" => [
                "email" => ["Email is invalid"],
            ]
        ]);
    }

    /**
     * Test to see when a specific field is left empty that the no data is available in the database.
     *
     * @param ApiTester $I
     * @param \Codeception\Example $example
     *
     * @dataProvider signUpProvider
     */
    public function signUpWithMissingData(ApiTester $I, \Codeception\Example $example) {
        $I->am("Client Side Application");
        // And
        $I->expectTo("get HTTP 401 error because a certain field is missing");
        // And
        $I->sendPOST("sign-up", $example["data"]);
        // Then
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::UNAUTHORIZED); // 401
        // And
        $I->seeResponseIsJson();
        // And
        $I->seeResponseContainsJson($example["json_contains"]);
    }
}