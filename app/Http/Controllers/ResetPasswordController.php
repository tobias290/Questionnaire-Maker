<?php

namespace App\Http\Controllers;

use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\ResetPasswordLink;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller {
    /**
     * Sends the link to reset password, or sends back error.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendLink(Request $request) {
        /** @var User $user */
        $user = User::where("email", $request->input("email"))->first();

        if (!$user) {
            return response()->json(["error" => [
                "message" => "Incorrect email"
            ]], 400);
        }

        //create a new token to be sent to the user.

        $reset = PasswordReset::create([
            "email" => $user->email,
            "token" => Str::random(50),
            "created_at" => Carbon::now(),
        ]);

        $user->notify(new ResetPasswordLink($reset->token));

        return response()->json(["success" => [
            "message" => "Email sent"
        ]], 200);
    }

    /**
     * Returns true if the token is valid
     * @param string $token - Token to check
     * @return \Illuminate\Http\JsonResponse
     */
    public function hasValidToken($token) {
        /** @var PasswordReset $tokenData */
        $tokenData = PasswordReset::where("token", $token)->first();

        if (!$tokenData) {
            return response()->json(["error" => [
                "message" => "Invalid Token",
            ]], 401);
        } else {
            return response()->json(["success" => [
                "message" => "Valid Token",
            ]], 200);
        }
    }

    /**
     * Resets the users password or redirects them to the login page.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function resetPassword(Request $request) {
        $password = $request->input("password");

        /** @var PasswordReset $tokenData */
        $tokenData = PasswordReset::where("token", $request->input("token"))->first();

        /** @var User $user */
        $user = User::where("email", $tokenData->email)->first();

        if (!$user || !$tokenData)
            return response()->json(["error" => [
            "message" => "Invalid Token",
        ]], 401);

        $user->password = Hash::make($password);
        $user->save();

        DB::delete("DELETE FROM password_resets where token = ?", [$tokenData->token]);

        return response()->json(["success" => [
            "message" => "Password changed",
        ]], 200);
    }
}
