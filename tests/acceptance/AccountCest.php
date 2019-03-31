<?php

use Codeception\Step\Argument\PasswordArgument;

class AccountCest {
    public function _before(\Step\Acceptance\QuestionnaireMaker $I) {
        $I->signUp();
        // And
        $I->amOnFrontEndPage("/account");
    }

    /**
     * Tests to see that the the correct details are visible.
     *
     * @param AcceptanceTester $I
     */
    public function seeDetails(AcceptanceTester $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("see my account details");
        // And
        $I->see("Account");
        // And
        $I->see("Toby Essex");
        // And
        $I->see("tobysx@gmail.com");
    }

    /**
     * Tests to see that the user can successfully change their first and last name.
     *
     * @param AcceptanceTester $I
     */
    public function changeName(AcceptanceTester $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("change my first name and surname");
        // And
        $I->seeInDatabase("user", [
            "email" => "tobysx@gmail.com",
            "first_name" => "Toby",
            "surname" => "Essex"
        ]);
        // Then
        $I->click(["id" => "edit-name"]);
        // And
        $I->see("Change Name");
        // And
        $I->fillField("firstName", "Tobey");
        // And
        $I->fillField("surname", "Newham");
        // Then
        $I->click("Change Name");
        // Then
        $I->wait(AcceptanceTester::WAIT_TIME);
        // Then
        $I->see("Tobey Newham");
        // And
        $I->seeInDatabase("user", [
            "email" => "tobysx@gmail.com",
            "first_name" => "Tobey",
            "surname" => "Newham"
        ]);
    }

    /**
     * Tests to see that the application gives an error when the first name field is empty.
     *
     * @param AcceptanceTester $I
     */
    public function changeNameWithMissingFirstName(AcceptanceTester $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->expectTo("get error as first name is missing");
        // And
        $I->seeInDatabase("user", [
            "email" => "tobysx@gmail.com",
            "first_name" => "Toby",
            "surname" => "Essex"
        ]);
        // Then
        $I->click(["id" => "edit-name"]);
        // And
        $I->see("Change Name");
        // And
        $I->fillField("firstName", ""); // As it is pre-filled it must be set to empty
        // And
        $I->fillField("surname", "Newham");
        // Then
        $I->click("Change Name");
        // Then
        $I->wait(AcceptanceTester::WAIT_TIME);
        // Then
        $I->see("First Name is required");
        // And
        $I->dontSeeInDatabase("user", [
            "email" => "tobysx@gmail.com",
            "first_name" => "",
            "surname" => "Newham"
        ]);
    }

    /**
     * Tests to see that the application gives an error when the surname name field is empty.
     *
     * @param AcceptanceTester $I
     */
    public function changeNameWithMissingSurname(AcceptanceTester $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->expectTo("get error as first name is missing");
        // And
        $I->seeInDatabase("user", [
            "email" => "tobysx@gmail.com",
            "first_name" => "Toby",
            "surname" => "Essex"
        ]);
        // Then
        $I->click(["id" => "edit-name"]);
        // And
        $I->see("Change Name");
        // And
        $I->fillField("firstName", "Tobey"); // As it is pre-filled it must be set to empty
        // And
        $I->fillField("surname", "");
        // Then
        $I->click("Change Name");
        // Then
        $I->wait(AcceptanceTester::WAIT_TIME);
        // Then
        $I->see("Surname is required");
        // And
        $I->dontSeeInDatabase("user", [
            "email" => "tobysx@gmail.com",
            "first_name" => "Tobey",
            "surname" => ""
        ]);
    }

    /**
     * Tests to see that the user can successfully change their email.
     *
     * @param AcceptanceTester $I
     */
    public function changeEmail(AcceptanceTester $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("change my email");
        // And
        $I->seeInDatabase("user", [
            "email" => "tobysx@gmail.com",
            "first_name" => "Toby",
            "surname" => "Essex"
        ]);
        // Then
        $I->click(["id" => "edit-email"]);
        // And
        $I->see("Change Email");
        // And
        $I->fillField("newEmail", "toby@sxhome.co.uk");
        // And
        $I->fillField("confirmEmail", "toby@sxhome.co.uk");
        // And
        $I->fillField("currentPassword",  new PasswordArgument("pass1234"));
        // Then
        $I->click("Change Email");
        // Then
        $I->wait(AcceptanceTester::WAIT_TIME);
        // Then
        $I->see("toby@sxhome.co.uk");
        // And
        $I->seeInDatabase("user", [
            "email" => "toby@sxhome.co.uk",
            "first_name" => "Toby",
            "surname" => "Essex"
        ]);
    }

    /**
     * Tests to see that the applications give an error when the new and confirm email fields do not match.
     *
     * @param AcceptanceTester $I
     */
    public function changeEmailWithUnMatchingEmails(AcceptanceTester $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->expectTo("get error as emails do not match");
        // And
        $I->seeInDatabase("user", [
            "email" => "tobysx@gmail.com",
            "first_name" => "Toby",
            "surname" => "Essex"
        ]);
        // Then
        $I->click(["id" => "edit-email"]);
        // And
        $I->see("Change Email");
        // And
        $I->fillField("newEmail", "toby@sxhome.co.uk");
        // And
        $I->fillField("confirmEmail", "not_valid_email");
        // And
        $I->fillField("currentPassword",  new PasswordArgument("pass1234"));
        // Then
        $I->click("Change Email");
        // Then
        $I->wait(AcceptanceTester::WAIT_TIME);
        // Then
        $I->see("Emails do not match");
        // And
        $I->dontSeeInDatabase("user", [
            "email" => "toby@sxhome.co.uk",
            "first_name" => "Toby",
            "surname" => "Essex"
        ]);
    }

    /**
     * Tests to see that the applications give an error when the new email field is left empty.
     *
     * @param AcceptanceTester $I
     */
    public function changeEmailWithMissingNewEmail(AcceptanceTester $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->expectTo("get error as new email is missing");
        // And
        $I->seeInDatabase("user", [
            "email" => "tobysx@gmail.com",
            "first_name" => "Toby",
            "surname" => "Essex"
        ]);
        // Then
        $I->click(["id" => "edit-email"]);
        // And
        $I->see("Change Email");
        // And
        $I->fillField("confirmEmail", "toby@sxhome.co.uk");
        // And
        $I->fillField("currentPassword",  new PasswordArgument("pass1234"));
        // Then
        $I->click("Change Email");
        // Then
        $I->wait(AcceptanceTester::WAIT_TIME);
        // Then
        $I->see("New email is required");
        // And
        $I->dontSeeInDatabase("user", [
            "email" => "toby@sxhome.co.uk",
            "first_name" => "Toby",
            "surname" => "Essex"
        ]);
    }

    /**
     * Tests to see that the applications give an error when the confirm email field is left empty.
     *
     * @param AcceptanceTester $I
     */
    public function changeEmailWithMissingConfirmEmail(AcceptanceTester $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->expectTo("get error as confirm email is missing");
        // And
        $I->seeInDatabase("user", [
            "email" => "tobysx@gmail.com",
            "first_name" => "Toby",
            "surname" => "Essex"
        ]);
        // Then
        $I->click(["id" => "edit-email"]);
        // And
        $I->see("Change Email");
        // And
        $I->fillField("newEmail", "toby@sxhome.co.uk");
        // And
        $I->fillField("currentPassword",  new PasswordArgument("pass1234"));
        // Then
        $I->click("Change Email");
        // Then
        $I->wait(AcceptanceTester::WAIT_TIME);
        // Then
        $I->see("Confirm email is required");
        // And
        $I->dontSeeInDatabase("user", [
            "email" => "toby@sxhome.co.uk",
            "first_name" => "Toby",
            "surname" => "Essex"
        ]);
    }

    /**
     * Tests to see that the applications give an error when the password field is left empty.
     *
     * @param AcceptanceTester $I
     */
    public function changeEmailWithMissingPassword(AcceptanceTester $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->expectTo("get error as password is missing");
        // And
        $I->seeInDatabase("user", [
            "email" => "tobysx@gmail.com",
            "first_name" => "Toby",
            "surname" => "Essex"
        ]);
        // Then
        $I->click(["id" => "edit-email"]);
        // And
        $I->see("Change Email");
        // And
        $I->fillField("newEmail", "toby@sxhome.co.uk");
        // And
        $I->fillField("confirmEmail", "toby@sxhome.co.uk");
        // Then
        $I->click("Change Email");
        // Then
        $I->wait(AcceptanceTester::WAIT_TIME);
        // Then
        $I->see("Password is required");
        // And
        $I->dontSeeInDatabase("user", [
            "email" => "toby@sxhome.co.uk",
            "first_name" => "Toby",
            "surname" => "Essex"
        ]);
    }

    /**
     * Tests to see that the applications give an error when the password field is incorrect.
     *
     * @param AcceptanceTester $I
     */
    public function changeEmailWithIncorrectPassword(AcceptanceTester $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->expectTo("get error as password is incorrect");
        // And
        $I->seeInDatabase("user", [
            "email" => "tobysx@gmail.com",
            "first_name" => "Toby",
            "surname" => "Essex"
        ]);
        // Then
        $I->click(["id" => "edit-email"]);
        // And
        $I->see("Change Email");
        // And
        $I->fillField("newEmail", "toby@sxhome.co.uk");
        // And
        $I->fillField("confirmEmail", "toby@sxhome.co.uk");
        // And
        $I->fillField("currentPassword",  new PasswordArgument("incorrect_password"));
        // Then
        $I->click("Change Email");
        // Then
        $I->wait(AcceptanceTester::WAIT_TIME);
        // Then
        $I->see("Password is incorrect");
        // And
        $I->dontSeeInDatabase("user", [
            "email" => "toby@sxhome.co.uk",
            "first_name" => "Toby",
            "surname" => "Essex"
        ]);
    }

    /**
     * Tests to see that the user can successfully change their password.
     *
     * @param AcceptanceTester $I
     */
    public function changePassword(AcceptanceTester $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("change my password");
        // Then
        $I->click(["id" => "edit-password"]);
        // And
        $I->see("Change Password");
        // And
        $I->fillField("currentPassword", new PasswordArgument("pass1234"));
        // And
        $I->fillField("newPassword", new PasswordArgument("password"));
        // And
        $I->fillField("confirmPassword",  new PasswordArgument("password"));
        // Then
        $I->click("Change Password");
    }

    /**
     * Tests to see that the applications give an error when the new and confirm password fields do not match.
     *
     * @param AcceptanceTester $I
     */
    public function changePasswordWithUnMatchingPasswords(AcceptanceTester $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->expectTo("get an error as the passwords do not match");
        // Then
        $I->click(["id" => "edit-password"]);
        // And
        $I->see("Change Password");
        // And
        $I->fillField("currentPassword", new PasswordArgument("pass1234"));
        // And
        $I->fillField("newPassword", new PasswordArgument("password"));
        // And
        $I->fillField("confirmPassword",  new PasswordArgument("unmatching_password"));
        // Then
        $I->click("Change Password");
        // And
        $I->see("Passwords do not match");
    }

    /**
     * Tests to see that the applications give an error when the current password field is left empty.
     *
     * @param AcceptanceTester $I
     */
    public function changePasswordsWithMissingCurrentPassword(AcceptanceTester $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->expectTo("get an error as current password is missing");
        // Then
        $I->click(["id" => "edit-password"]);
        // And
        $I->see("Change Password");
        // And
        $I->fillField("newPassword", new PasswordArgument("password"));
        // And
        $I->fillField("confirmPassword",  new PasswordArgument("password"));
        // Then
        $I->click("Change Password");
        // And
        $I->see("Current password is required");
    }

    /**
     * Tests to see that the applications give an error when the new password field is left empty.
     *
     * @param AcceptanceTester $I
     */
    public function changePasswordsWithMissingNewPassword(AcceptanceTester $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->expectTo("get an error as new password is missing");
        // Then
        $I->click(["id" => "edit-password"]);
        // And
        $I->see("Change Password");
        // And
        $I->fillField("currentPassword", new PasswordArgument("pass1234"));
        // And
        $I->fillField("confirmPassword",  new PasswordArgument("password"));
        // Then
        $I->click("Change Password");
        // And
        $I->see("New password is required");
    }

    /**
     * Tests to see that the applications give an error when the confirm password field is left empty.
     *
     * @param AcceptanceTester $I
     */
    public function changePasswordsWithMissingConfirmPassword(AcceptanceTester $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->expectTo("get an error as confirm password is missing");
        // Then
        $I->click(["id" => "edit-password"]);
        // And
        $I->see("Change Password");
        // And
        $I->fillField("currentPassword", new PasswordArgument("pass1234"));
        // And
        $I->fillField("newPassword", new PasswordArgument("password"));
        // Then
        $I->click("Change Password");
        // And
        $I->see("Confirm password is required");
    }

    /**
     * Tests to see that the applications give an error when the password is incorrect.
     *
     * @param AcceptanceTester $I
     */
    public function changePasswordsWithMissingIncorrectPassword(AcceptanceTester $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->expectTo("get an error as current password is incorrect");
        // Then
        $I->click(["id" => "edit-password"]);
        // And
        $I->see("Change Password");
        // And
        $I->fillField("currentPassword", new PasswordArgument("incorrect_password"));
        // And
        $I->fillField("newPassword", new PasswordArgument("password"));
        // And
        $I->fillField("confirmPassword",  new PasswordArgument("password"));
        // Then
        $I->click("Change Password");
        // And
        $I->see("Password is incorrect");
    }

    /**
     * Tests to see that the user can successfully delete their account.
     *
     * @param AcceptanceTester $I
     */
    public function deleteAccount(AcceptanceTester $I) {
        $I->am("Questionnaire Maker");
        // And
        $I->wantTo("delete my account");
        // Then
        $I->click(["id" => "delete-account"]);
        // And
        $I->see("Delete Account");
        // And
        $I->see("Are you sure you want to delete your account?");
        // Then
        $I->click("Delete");
        // And
        $I->seeInCurrentUrl("/");
        // And
        $I->dontSeeInDatabase("user", [
            "email" => "tobysx@gmail.com",
            "first_name" => "Toby",
            "surname" => "Essex"
        ]);
    }
}
