<?php 

class SignUpCest {
    public function _before(FunctionalTester $I) {
    }

    protected function signUpProvider() {
        return [
            [
                "field" => "Email",
                "data" => [
                    "firstName" => "Toby",
                    "surname" => "Essex",
                    "password" => "pass1234",
                    "confirmPassword" => "pass1234",
                ],
                "cant_see" => [
                    "first_name" => "Toby",
                    "surname" => "Essex",
                ]
            ],
            [
                "field" => "First Name",
                "data" => [
                    "email" => "tobiascompany@gmail.com",
                    "surname" => "Essex",
                    "password" => "pass1234",
                    "confirmPassword" => "pass1234",
                ],
                "cant_see" => [
                    "email" => "tobiascompany@gmail.com",
                    "surname" => "Essex",
                ]
            ],
            [
                "field" => "Surname",
                "data" => [
                    "email" => "tobiascompany@gmail.com",
                    "firstName" => "Toby",
                    "password" => "pass1234",
                    "confirmPassword" => "pass1234",
                ],
                "cant_see" => [
                    "email" => "tobiascompany@gmail.com",
                    "first_name" => "Toby",
                ]
            ],
            [
                "field" => "Password",
                "data" => [
                    "email" => "tobiascompany@gmail.com",
                    "firstName" => "Toby",
                    "surname" => "Essex",
                    "confirmPassword" => "pass1234",
                ],
                "cant_see" => [
                    "email" => "tobiascompany@gmail.com",
                    "first_name" => "Toby",
                    "surname" => "Essex",
                ]
            ],
            [
                "field" => "Confirm Password",
                "data" => [
                    "email" => "tobiascompany@gmail.com",
                    "firstName" => "Toby",
                    "surname" => "Essex",
                    "password" => "pass1234",
                ],
                "cant_see" => [
                    "email" => "tobiascompany@gmail.com",
                    "first_name" => "Toby",
                    "surname" => "Essex",
                ]
            ],
        ];
    }

    /**
     * Test to see when the user signs up successfully their details are stored in the database.
     *
     * @param \Step\Functional\QuestionnaireMaker $I
     */
    public function signUp(\Step\Functional\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("sign up so I can make questionnaires");
        // And
        $I->signUp();
    }
//
//    /**
//     * Test to see when a user attempts to sign up with un-matching passwords that their details are not saved to the database.
//     *
//     * @param FunctionalTester $I
//     */
//    public function signUpWithUnMatchingPasswords(FunctionalTester $I) {
//        $I->am("Questionnaire Maker");
//        // And
//        $I->expectTo("see no data in the database because the passwords do not match");
//        // And
//        $I->amOnFrontEndPage("/sign-up");
//        // And
//        $I->see("Sign Up");
//        // And
//        $I->fillField("email", "tobysx@gmail.com");
//        $I->fillField("firstName", "Toby");
//        $I->fillField("surname", "Essex");
//        $I->fillField("confirmPassword", "pass1234");
//        $I->fillField("password", "password");
//        // And
//        $I->click("Sign Up");
//        // Then
//        $I->expect("not too see a user record added to the database");
//        // And
//        $I->cantSeeRecord("user", [
//            "email" => "tobiascompany@gmail.com",
//            "first_name" => "Toby",
//            "surname" => "Essex",
//        ]);
//    }
//
//    /**
//     * Test to see when a user attempts to sign up with an invalid email that their details are not saved to the database.
//     *
//     * @param FunctionalTester $I
//     */
//    public function signUpWithInvalidEmail(FunctionalTester $I) {
//        $I->am("Questionnaire Maker");
//        // And
//        $I->expectTo("see no data in the database because the passwords do not match");
//        // And
//        $I->amOnFrontEndPage("/sign-up");
//        // And
//        $I->see("Sign Up");
//        // And
//        $I->fillField("email", "not_valid_email");
//        $I->fillField("firstName", "Toby");
//        $I->fillField("surname", "Essex");
//        $I->fillField("confirmPassword", "pass1234");
//        $I->fillField("password", "pass1234");
//        // And
//        $I->click("Sign Up");
//        // Then
//        $I->expect("not too see a user record added to the database");
//        // And
//        $I->cantSeeRecord("user", [
//            "email" => "not_valid_email",
//            "first_name" => "Toby",
//            "surname" => "Essex",
//        ]);
//    }
//
//    /**
//     * Test to see when a specific field is left empty that the no data is available in the database.
//     *
//     * @param FunctionalTester $I
//     * @param \Codeception\Example $example
//     *
//     * @dataProvider signUpProvider
//     */
//    public function signUpWithMissingData(FunctionalTester $I, \Codeception\Example $example) {
//        $I->am("Questionnaire Maker");
//        // And
//        $I->expectTo("see and error because my the {$example["field"]} input was left empty");
//        // And
//        $I->amOnFrontEndPage("/sign-up");
//        // And
//        $I->see("Sign Up");
//        // And
//
//        foreach ($example["data"] as $field => $value)
//            $I->fillField($field, $value);
//
//        // And
//        $I->click("Sign Up");
//        // Then
//        $I->expect("not too see a user record added to the database");
//        // And
//        $I->cantSeeRecord("user", $example["cant_see"]);
//    }
}
