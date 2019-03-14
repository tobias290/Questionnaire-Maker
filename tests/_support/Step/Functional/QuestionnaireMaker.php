<?php
namespace Step\Functional;

class QuestionnaireMaker extends \FunctionalTester {

    /**
     * Test to see when the user signs up their details are stored in the database
     */
    public function signUp() {
        $I = $this;

        $I->amOnPage("/");

//        $I->amOnFrontEndPage("/sign-up");
//        // And
//        $I->see("Sign Up");
//        // And
//        $I->fillField("email", "tobysx@gmail.com");
//        $I->fillField("firstName", "Toby");
//        $I->fillField("surname", "Essex");
//        $I->fillField("confirmPassword", "pass1234");
//        $I->fillField("password", "pass1234");
//        // And
//        $I->click("Sign Up");
//        // Then
//        $I->canSeeRecord("user", [
//            "email" => "tobiascompany@gmail.com",
//            "first_name" => "Toby",
//            "surname" => "Essex",
//        ]);
    }

    public function login() {
        $I = $this;
    }

}