<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix("public")->group(function () {
    Route::get("questionnaire-categories", "PublicController@categories");
    Route::get("questionnaires", "PublicController@publicQuestionnaires");
    Route::get("questionnaire/{id}/answer", "PublicController@answerQuestionnaire");

    Route::post("questionnaire/{id}/submit", "PublicController@submitQuestionnaire");
});

Route::prefix("user")->group(function (){
    Route::post("sign-up", "UserController@signUp");
    Route::post("login", "UserController@login");
});

Route::group(["middleware" => "auth:api"], function () { // Bearer Token Needed
    Route::prefix("user")->group(function () {
        Route::get("sign-out", "UserController@signOut");
        Route::get("details", "UserController@details");
        Route::patch("edit", "UserController@edit");

        // _NOTE: Post method use as body cannot be send using angular with delete method
        // _NOTE: Body is needed as the current password is used for extra verification
        Route::post("delete", "UserController@delete");

        Route::prefix("settings")->group(function () {
            Route::get("all", "SettingsController@all");
            Route::patch("edit", "SettingsController@edit");
        });

        Route::prefix("notifications")->group(function () {
            Route::get("all", "NotificationsController@all");

            Route::patch("read/{id}", "NotificationsController@read");
            Route::patch("read-all", "NotificationsController@readAll");

            Route::delete("delete/{id}", "NotificationsController@delete");
            Route::delete("delete-all", "NotificationsController@deleteAll");
        });
    });

    Route::prefix("questionnaire")->group(function () {
        Route::post("create", "QuestionnaireController@create");
        Route::delete("delete/{id}", "QuestionnaireController@delete");
        Route::patch("edit/{id}", "QuestionnaireController@edit");

        Route::get("all", "QuestionnaireController@all");
        Route::get("{id}", "QuestionnaireController@get");
        Route::get("{id}/preview", "QuestionnaireController@previewQuestionnaire");
    });

    Route::prefix("question")->group(function () {
        Route::get("questionnaire/{id}/questions", "QuestionController@questionnaireQuestions");

        Route::get("closed/{id}/options", "QuestionClosedOptionController@questionClosedOptions");

        Route::prefix("add")->group(function () {
            Route::post("open", "QuestionController@addOpen");
            Route::post("closed", "QuestionController@addClosed");
            Route::post("scaled", "QuestionController@addScaled");

            Route::post("closed/option", "QuestionClosedOptionController@add");
        });

        Route::prefix("delete")->group(function () {
            Route::delete("open/{id}", "QuestionController@deleteOpen");
            Route::delete("closed/{id}", "QuestionController@deleteClosed");
            Route::delete("scaled/{id}", "QuestionController@deleteScaled");

            Route::delete("closed/option/{id}", "QuestionClosedOptionController@delete");
        });

        Route::prefix("edit")->group(function () {
            Route::patch("open/{id}", "QuestionController@editOpen");
            Route::patch("closed/{id}", "QuestionController@editClosed");
            Route::patch("scaled/{id}", "QuestionController@editScaled");

            Route::patch("closed/option/{id}", "QuestionClosedOptionController@edit");
        });

        Route::prefix("duplicate")->group(function () {
            Route::post("open", "QuestionController@duplicateOpen");
            Route::post("closed", "QuestionController@duplicateClosed");
            Route::post("scaled", "QuestionController@duplicateScaled");
        });
    });

    Route::prefix("responses")->group(function () {
        Route::get("questionnaire/{id}/responses", "QuestionnaireResponsesController@responses");
    });
});


Route::get("/email-test", "UserController@emailTest");