<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signUp(Request $request) {
        // Custom messages if the validation fails
        $messages = [
            "email.email" => "Email is invalid",
            "email.required" => "Email is required",
            "first_name.required" => "First Name is required",
            "surname.required" => "Surname is required",
            "password.required" => "Password is required",
            "confirm_password.required" => "Confirm Password is required",
            "confirm_password.same"    => "Passwords do not match",
        ];

        // Create a validator to make sure the data is valid
        $validator = Validator::make($request->all(), [
            "first_name" => "required",
            "surname" => "required",
            "email" => "required|email",
            "password" => "required",
            "confirm_password" => "required|same:password",
        ], $messages);

        // If validation fails return response to client
        if ($validator->fails())
            return response()->json(["error" => $validator->errors()], 401);

        // Data is valid, get the user data and hash password and add date joined
        $data = $request->all();
        $data["password"] = Hash::make($data["password"]);
        $data["date_joined"] = date("Y-m-d");

        // Create user and create access token
        $user = User::create($data);
        $json["email"] = $user->email;
        $json["token"] = $user->createToken("QuestionnaireMaker")->accessToken;

        // Return HTTP 201, resource created
        return response()->json(["success" => $json], 201);
    }
}
