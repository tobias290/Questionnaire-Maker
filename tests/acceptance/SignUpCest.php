<?php 

class SignUpCest {
    public function _before(AcceptanceTester $I) {
    }

    protected function signUpProvider() {
        return [
            [
                "field" => "Email",
                "data" => [
                    "first_name" => "Toby",
                    "surname" => "Essex",
                    "password" => "pass1234",
                    "confirm_password" => "pass1234",
                ]
            ],
            [
                "field" => "First Name",
                "data" => [
                    "email" => "tobiascompany@gmail.com",
                    "surname" => "Essex",
                    "password" => "pass1234",
                    "confirm_password" => "pass1234",
                ]
            ],
            [
                "field" => "Surname",
                "data" => [
                    "email" => "tobiascompany@gmail.com",
                    "first_name" => "Toby",
                    "password" => "pass1234",
                    "confirm_password" => "pass1234",
                ]
            ],
            [
                "field" => "Password",
                "data" => [
                    "email" => "tobiascompany@gmail.com",
                    "first_name" => "Toby",
                    "surname" => "Essex",
                    "confirm_password" => "pass1234",
                ]
            ],
            [
                "field" => "Confirm Password",
                "data" => [
                    "email" => "tobiascompany@gmail.com",
                    "first_name" => "Toby",
                    "surname" => "Essex",
                    "password" => "pass1234",
                ]
            ],
        ];
    }

    /**
     * Test to see when the user signs up it logs them in and redirects them to their dashboard.
     *
     * @param \Step\Acceptance\QuestionnaireMaker $I
     */
    public function signUp(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("sign up so I can make questionnaires");
        // And
        $I->signUp();
    }

    /**
     * Test to see when a user attempts to sign up with un-matching passwords the form does not submit and an error appears.
     *
     * @param AcceptanceTester $I
     */
    public function signUpWithUnMatchingPasswords(AcceptanceTester $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->expectTo("see and error because my passwords do not match");
        // And
        $I->amOnPage("sign-up");
        // And
        $I->see("Sign Up");
        // And
        $I->submitForm("#signup", [
            "email" => "tobiascompany@gmail.com",
            "first_name" => "Toby",
            "surname" => "Essex",
            "password" => "pass1234",
            "confirm_password" => "password",
        ]);
        // Then
        $I->expect("that the form is not submitted");
        // And
        $I->dontSeeInCurrentUrl("/dashboard");
        // And
        $I->dontSee("Dashboard", "div.top-bar-left");
        // And
        $I->see("Passwords do not match");
    }

    /**
     * Test to see when a user attempts to sign up with invalid email the form does not submit and an error appears.
     *
     * @param AcceptanceTester $I
     */
    public function signUpWithInvalidEmail(AcceptanceTester $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->expectTo("see and error because my email is invalid");
        // And
        $I->amOnPage("sign-up");
        // And
        $I->see("Sign Up");
        // And
        $I->submitForm("#signup", [
            "email" => "not_valid_email",
            "first_name" => "Toby",
            "surname" => "Essex",
            "password" => "pass1234",
            "confirm_password" => "pass1234",
        ]);
        // Then
        $I->expect("that the form is not submitted");
        // And
        $I->dontSeeInCurrentUrl("/dashboard");
        // And
        $I->dontSee("Dashboard", "div.top-bar-left");
        // And
        $I->see("Email is invalid");
    }

    /**
     * Test to see when a specific field is left empty that the correct error is raised and correct message is shown.
     *
     * @param AcceptanceTester $I
     * @param \Codeception\Example $example
     *
     * @dataProvider signUpProvider
     */
    public function signUpWithMissingData(AcceptanceTester $I, \Codeception\Example $example) {
        $I->am("Questionnaire Maker");
        // And
        $I->expectTo("see and error because my the {$example["field"]} input was left empty");
        // And
        $I->amOnPage("sign-up");
        // And
        $I->see("Sign Up");
        // And
        $I->submitForm("#signup", $example["data"]);
        // Then
        $I->expect("that the form is not submitted");
        // And
        $I->dontSeeInCurrentUrl("/dashboard");
        // And
        $I->dontSee("Dashboard", "div.top-bar-left");
        // And
        $I->see("{$example["field"]} is required");
    }
}
