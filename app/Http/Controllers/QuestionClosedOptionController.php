<?php

namespace App\Http\Controllers;

use App\Models\QuestionClosed;
use App\Models\QuestionClosedOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionClosedOptionController extends Controller {
    /**
     * Adds an option to a question
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request) {
        /** @var QuestionClosed $question */
        $question = QuestionClosed::find($request->input("question_closed_id"));

        // Check to see whether the current authenticated user owns the questionnaire
        // Only if they own it can they add a question
        if (Auth::id() != $question->questionnaire->user->id) {
            return response()->json(["error" => [
                "message" => "You do not own the questionnaire that this question belongs to, therefore you cannot add an option",
            ]], 401);
        }

        $question_option = $question->options()->create([
            "option" => "Untitled",
        ]);

        return response()->json(["success" => [
            "id" => $question_option->id,
            "message" => "Question option added"
        ]], 201);
    }

    /**
     * Edits an option.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request, $id) {
        $question_option = QuestionClosedOption::find($id);

        // Check to see whether the current authenticated user owns the questionnaire
        // Only if they own it can they add a question
        if (Auth::id() != $question_option->questionClosed->questionnaire->user->id) {
            return response()->json(["error" => [
                "message" => "You do not own the questionnaire that this question belongs to, therefore you cannot edit this option",
            ]], 401);
        }

        $question_option->fill($request->all());
        $question_option->save();

        return response()->json(["success" => [
            "message" => "Question option edited"
        ]], 200);
    }

    /**
     * Deletes an option.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id) {
        $question_option = QuestionClosedOption::find($id);

        // Check to see whether the current authenticated user owns the questionnaire
        // Only if they own it can they add a question
        if (Auth::id() != $question_option->questionClosed->questionnaire->user->id) {
            return response()->json(["error" => [
                "message" => "You do not own the questionnaire that this question belongs to, therefore you cannot edit this option",
            ]], 401);
        }

        $question_option->delete();

        return response()->json(["success" => [
            "message" => "Question option deleted"
        ]], 200);
    }
}
