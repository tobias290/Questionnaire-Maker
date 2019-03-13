<?php 

class SignUpCest {
    public function _before(AcceptanceTester $I) {
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
                ]
            ],
            [
                "field" => "First Name",
                "data" => [
                    "email" => "tobiascompany@gmail.com",
                    "surname" => "Essex",
                    "password" => "pass1234",
                    "confirmPassword" => "pass1234",
                ]
            ],
            [
                "field" => "Surname",
                "data" => [
                    "email" => "tobiascompany@gmail.com",
                    "firstName" => "Toby",
                    "password" => "pass1234",
                    "confirmPassword" => "pass1234",
                ]
            ],
            [
                "field" => "Password",
                "data" => [
                    "email" => "tobiascompany@gmail.com",
                    "firstName" => "Toby",
                    "surname" => "Essex",
                    "confirmPassword" => "pass1234",
                ]
            ],
            [
                "field" => "Confirm Password",
                "data" => [
                    "email" => "tobiascompany@gmail.com",
                    "firstName" => "Toby",
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
        $I->amOnFrontEndPage("/sign-up");
        // And
        $I->see("Sign Up");
        // And
        $I->fillField("email", "tobiascompany@gmail.com");
        $I->fillField("firstName", "Toby");
        $I->fillField("surname", "Essex");
        $I->fillField("confirmPassword", "pass1234");
        $I->fillField("password", "password");
        // And
        $I->click("Sign Up");
        // Then
        $I->expect("that the form is not submitted");
        // And
        $I->dontSeeInCurrentUrl("dashboard");
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
        $I->amOnFrontEndPage("/sign-up");
        // And
        $I->see("Sign Up");
        // And
        $I->fillField("email", "not_valid_email");
        $I->fillField("firstName", "Toby");
        $I->fillField("surname", "Essex");
        $I->fillField("confirmPassword", "pass1234");
        $I->fillField("password", "pass1234");
        // And
        $I->click("Sign Up");
        // Then
        $I->wait(1);
        // And Then
        $I->expect("that the form is not submitted");
        // And
        $I->dontSeeInCurrentUrl("dashboard");
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
     * @throws Exception
     */
    public function signUpWithMissingData(AcceptanceTester $I, \Codeception\Example $example) {
        $I->am("Questionnaire Maker");
        // And
        $I->expectTo("see and error because my the {$example["field"]} input was left empty");
        // Then
        $I->reloadPage();
        // And
        $I->amOnFrontEndPage("/sign-up");
        // And
        $I->see("Sign Up");
        // And

        foreach ($example["data"] as $field => $value)
            $I->fillField($field, $value);

        // And
        $I->click("Sign Up");
        // Then
        $I->wait(1);
        // And Then
        $I->expect("that the form is not submitted");
        // And
        $I->dontSeeInCurrentUrl("dashboard");
        // And
        $I->dontSee("Dashboard", "div.top-bar-left");
        // And
        $I->see("{$example["field"]} is required");
    }
}
