<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionnaireResponsesController extends Controller {
    public function responses($id) {
        $questionnaire = Questionnaire::where("id", $id)
            ->with([
                "closedQuestions",
                "closedQuestions.options",
                "scaledQuestions",
                "scaledQuestions.responses",
                "openQuestions",
                "openQuestions.responses",
            ])
            ->first();

        // Check to see whether the current authenticated user owns the questionnaire
        // Only if they own it can they delete it
        if (Auth::id() != $questionnaire->user->id) {
            return response()->json(["error" => [
                "message" => "You do not own that questionnaire, therefore you cannot view its responses",
            ]], 401);
        }

        return response()->json(["success" => [
            "questionnaire" => $questionnaire
        ]], 200);
    }
}
