<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller {
    /**
     * Gets all of the user's settings.
     */
    public function all() {
        return response()->json(Auth::user()->settings, 200);
    }

    /**
     * Edit's the user's settings
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request) {
        /** @var Settings $settings */
        $settings = Settings::find(Auth::id());

        $settings->fill($request->all());
        $settings->save();

        return response()->json(["success" => [
            "message" => "Settings edited",
        ]], 200);
    }
}
