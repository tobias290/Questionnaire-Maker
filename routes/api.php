<?php

use Illuminate\Http\Request;

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

Route::post("sign-up", "UserController@signUp");
Route::post("login", "UserController@login");

Route::group(["middleware" => "auth:api"], function () {
    // Authentication needed for any routes here

    Route::get("sign-out", "UserController@signOut");
    Route::get("details", "UserController@details");
});
