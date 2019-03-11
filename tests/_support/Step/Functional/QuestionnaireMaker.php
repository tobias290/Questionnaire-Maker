<?php
namespace Step\Functional;

class QuestionnaireMaker extends \FunctionalTester {

    /**
     * Test to see when the user signs up their details are stored in the database
     */
    public function signUp() {
        $I = $this;

        $I->amOnPage("sign-up");
        // And
        $I->see("Sign Up");
        // And
        $I->submitForm("#signup", [
            "email" => "tobiascompany@gmail.com",
            "first_name" => "Toby",
            "surname" => "Essex",
            "password" => "pass1234",
            "confirm_password" => "pass1234",
        ]);
        // Then
        $I->canSeeRecord("user", [
            "email" => "tobiascompany@gmail.com",
            "first_name" => "Toby",
            "surname" => "Essex",
        ]);
    }

    public function login() {
        $I = $this;
    }

}