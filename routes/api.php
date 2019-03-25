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


Route::prefix("user")->group(function (){
    Route::post("sign-up", "UserController@signUp");
    Route::post("login", "UserController@login");
});

Route::group(["middleware" => "auth:api"], function () { // Bearer Token Needed
    Route::prefix("user")->group(function () {
        Route::get("sign-out", "UserController@signOut");
        Route::get("details", "UserController@details");
    });

    Route::prefix("questionnaire")->group(function () {
        Route::get("categories", "QuestionnaireController@categories");

        Route::post("create", "QuestionnaireController@create");
        Route::delete("delete/{id}", "QuestionnaireController@delete");
        Route::patch("edit/{id}", "QuestionnaireController@edit");

        Route::get("all", "QuestionnaireController@all");
        Route::get("{id}", "QuestionnaireController@get");
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
});
