<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use App\Models\QuestionnaireCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionnaireController extends Controller {
    public function categories() {
        return response()->json(QuestionnaireCategory::all(), 200);
    }

    public function create(Request $request) {
        if (!$request->has("title")) {
            return response()->json(["error" => [
                "message" => "Title is required",
            ]], 401);
        }

        if (!$request->has("questionnaire_category_id")) {
            return response()->json(["error" => [
                "message" => "Questionnaire Category is required",
            ]], 401);
        }

        /** @var User $user */
        $user = Auth::user();

        $questionnaire = $user->questionnaires()->create($request->all());

        return response()->json(["success" => [
            "questionnaire_id" => $questionnaire->id,
        ]], 201);
    }
}
