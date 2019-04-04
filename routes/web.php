<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    return redirect("/frontend/dist/frontend/index.html");
});

Route::get("login", function () {
    return redirect("/frontend/dist/frontend/#/login");
})->name("login");


Route::prefix("admin")->group(function() {
    Route::match(["GET", "POST"], "login", "AdminController@login")->name("adminLogin");
    Route::get("sign-out", "AdminController@signOut")->name("adminSignOut");
    Route::get("dashboard", "AdminController@dashboard");

    Route::prefix("questionnaire")->group(function() {
        Route::get("{id}/lock", "AdminController@lockQuestionnaire");
        Route::get("{id}/un-report", "AdminController@unReportQuestionnaire");
    });
});
