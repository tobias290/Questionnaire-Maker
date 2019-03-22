<?php

namespace App\Http\Controllers;

use App\Models\QuestionClosed;
use App\Models\Questionnaire;
use App\Models\QuestionOpen;
use App\Models\QuestionScaled;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class QuestionController extends Controller {
    /**
     * Returns all the questions related to the given id.
     *
     * @param $id - Questionnaire ID.
     * @return \Illuminate\Http\JsonResponse
     */
    public function questionnaireQuestions($id) {
        /** @var Questionnaire $questionnaire */
        $questionnaire = Questionnaire::find($id);

        // Check to see whether the current authenticated user owns the questionnaire
        // Only if they own it can they add a question
        if (Auth::id() != $questionnaire->user->id) {
            return response()->json(["error" => [
                "message" => "You do not own that questionnaire",
            ]], 401);
        }

        return response()->json(["success" => [
            "open" => $questionnaire->openQuestions,
            "closed" => $questionnaire->closedQuestions,
            "scaled" => $questionnaire->scaledQuestions,
        ]], 200);
    }

    // _________________________________________________________________________________________________________________

    /**
     * Edits the details of a question.
     *
     * @param QuestionClosed | QuestionOpen | QuestionScaled $question
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($question, $data) {
        // Check to see whether the current authenticated user owns the questionnaire
        // Only if they own it can they add a question
        if (Auth::id() != $question->questionnaire->user->id) {
            return response()->json(["error" => [
                "message" => "You do not own that questionnaire, therefore you cannot edit the question",
            ]], 401);
        }

        $question->fill($data);
        $question->save();

        return response()->json(["success" => [
            "message" => "Question edited"
        ]], 200);
    }

    /**
     * Delete a question from a questionnaire.
     *
     * @param QuestionClosed | QuestionOpen | QuestionScaled $question
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete($question) {
        // Check to see whether the current authenticated user owns the questionnaire that the question belongs to
        // Only if they own it can they delete the question
        if (Auth::id() != $question->questionnaire->user->id) {
            return response()->json(["error" => [
                "message" => "You do not own that questionnaire, therefore you cannot delete a question",
            ]], 401);
        }

        $question->delete();

        return response()->json(["error" => [
            "message" => "Question deleted",
        ]], 200);
    }

    // _________________________________________________________________________________________________________________

    /**
     * Adds an open question to a given questionnaire.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addOpen(Request $request) {
        /** @var Questionnaire $questionnaire */
        $questionnaire = Questionnaire::find($request->input("questionnaire_id"));

        // Check to see whether the current authenticated user owns the questionnaire
        // Only if they own it can they add a question
        if (Auth::id() != $questionnaire->user->id) {
            return response()->json(["error" => [
                "message" => "You do not own that questionnaire",
            ]], 401);
        }

        $question = $questionnaire->openQuestions()->create([
            "name" => "Untitled",
            "position" => $request->input("position"),
            "is_long" => $request->input("is_long"),
        ]);

        return response()->json(["success" => [
            "id" => $question->id,
            "message" => "Question added"
        ]], 201);
    }

    /**
     * Edits the details of an open question.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function editOpen(Request $request, $id) {
        return $this->edit(QuestionOpen::find($id), $request->all());
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function deleteOpen($id) {
       return $this->delete(QuestionOpen::find($id));
    }

    // _________________________________________________________________________________________________________________

    /**
     * Adds an closed question to a given questionnaire.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addClosed(Request $request) {
        /** @var Questionnaire $questionnaire */
        $questionnaire = Questionnaire::find($request->input("questionnaire_id"));

        // Check to see whether the current authenticated user owns the questionnaire
        // Only if they own it can they add a question
        if (Auth::id() != $questionnaire->user->id) {
            return response()->json(["error" => [
                "message" => "You do not own that questionnaire",
            ]], 401);
        }

        $question = $questionnaire->closedQuestions()->create([
            "name" => "Untitled",
            "position" => $request->input("position"),
            "type" => $request->input("type"),
        ]);

        return response()->json(["success" => [
            "id" => $question->id,
            "message" => "Question added"
        ]], 201);
    }

    /**
     * Edits the details of an closed question.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function editClosed(Request $request, $id) {
        return $this->edit(QuestionClosed::find($id), $request->all());
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function deleteClosed($id) {
        return $this->delete(QuestionClosed::find($id));
    }

    // _________________________________________________________________________________________________________________

    /**
     * Adds an scaled question to a given questionnaire.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addScaled(Request $request) {
        /** @var Questionnaire $questionnaire */
        $questionnaire = Questionnaire::find($request->input("questionnaire_id"));

        // Check to see whether the current authenticated user owns the questionnaire
        // Only if they own it can they add a question
        if (Auth::id() != $questionnaire->user->id) {
            return response()->json(["error" => [
                "message" => "You do not own that questionnaire",
            ]], 401);
        }

        $question = $questionnaire->scaledQuestions()->create([
            "name" => "Untitled",
            "position" => $request->input("position"),
            "type" => $request->input("type"),
        ]);

        return response()->json(["success" => [
            "id" => $question->id,
            "message" => "Question added"
        ]], 201);
    }

    /**
     * Edits the details of an scaled question.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function editScaled(Request $request, $id) {
        return $this->edit(QuestionScaled::find($id), $request->all());
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function deleteScaled($id) {
        return $this->delete(QuestionScaled::find($id));
    }
}
