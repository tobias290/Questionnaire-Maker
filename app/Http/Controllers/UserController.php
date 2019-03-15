<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {
    /**
     * Takes users data and creates an account.
     *
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

    /**
     * Takes the users email and password and check to see whether they have an account.
     * If so log them in, otherwise send appropriate error response.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request) {
        if (!$request->has("email"))
            return response()->json(["error" => ["message" => "Email is required"]], 401);
        elseif (!$request->has("password"))
            return response()->json(["error" => ["message" => "Password is required"]], 401);

        if(Auth::attempt($request->only("email", "password"))){
            $user = Auth::user();
            $success["token"] =  $user->createToken("QuestionnaireMaker")->accessToken;
            return response()->json(["success" => $success], 200);
        } else {
            return response()->json(["error" => ["message" => "Email or password is incorrect"]], 401);
        }
    }

    /**
     * Sign outs the user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function signOut() {
        Auth::user()->token()->revoke();

        return response()->json(["success" => true], 200);
    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|null - Returns the authenticated users details.
     */
    public function details() {
        return Auth::user();
    }
}
