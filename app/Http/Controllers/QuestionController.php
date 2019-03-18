<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use Illuminate\Http\Request;


class QuestionController extends Controller {
    public function questionnaireQuestions($id) {
        /** @var Questionnaire $questionnaire */
        $questionnaire = Questionnaire::find($id);

        return response()->json(["success" => [
            "open" => $questionnaire->openQuestions(),
            "closed" => $questionnaire->closedQuestions(),
            "scaled" => $questionnaire->scaledQuestions(),
        ]], 200);
    }

    public function addOpen(Request $request) {
        /** @var Questionnaire $questionnaire */
        $questionnaire = Questionnaire::find($request->input("questionnaire_id"));

        $questionnaire->openQuestions()->create([
            "name" => "Untitled",
            "position" => $request->input("position"),
            "is_long" => $request->input("is_long"),
            "is_required" => false,
        ]);

        return response()->json(["success" => [
            "message" => "Question added"
        ]], 201);
    }

    public function addClosed(Request $request) {
        /** @var Questionnaire $questionnaire */
        $questionnaire = Questionnaire::find($request->input("questionnaire_id"));

        $questionnaire->closedQuestions()->create([
            "name" => "Untitled",
            "position" => $request->input("position"),
            "type" => $request->input("type"),
            "is_required" => false,
        ]);

        return response()->json(["success" => [
            "message" => "Question added"
        ]], 201);
    }

    public function addScaled(Request $request) {
        /** @var Questionnaire $questionnaire */
        $questionnaire = Questionnaire::find($request->input("questionnaire_id"));

        $questionnaire->scaledQuestions()->create([
            "name" => "Untitled",
            "position" => $request->input("position"),
            "min" => 0,
            "max" => 5,
            "interval" => 1,
            "type" => $request->input("type"),
            "is_required" => false,
        ]);

        return response()->json(["success" => [
            "message" => "Question added"
        ]], 201);
    }
}
