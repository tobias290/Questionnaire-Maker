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

        Route::prefix("add")->group(function () {
            Route::post("open", "QuestionController@addOpen");
            Route::post("closed", "QuestionController@addClosed");
//            Route::post("closed/option", "");
            Route::post("scaled", "QuestionController@addScaled");
        });
    });
});
