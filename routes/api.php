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

        Route::get("all", "QuestionnaireController@all");
    });
});
