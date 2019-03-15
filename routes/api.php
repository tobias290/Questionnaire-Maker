<?php


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

use Illuminate\Support\Facades\Route;

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
       Route::post("create", "QuestionnaireController@create");
    });
});
