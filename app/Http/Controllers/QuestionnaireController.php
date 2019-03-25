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

    /**
     * Created a questionnaire.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Edits a questionnaire
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request, $id) {
        $questionnaire = Questionnaire::find($id);

        // Check to see whether the current authenticated user owns the questionnaire
        // Only if they own it can they delete it
        if (Auth::id() != $questionnaire->user->id) {
            return response()->json(["error" => [
                "message" => "You do not own that questionnaire",
            ]], 401);
        }

        $questionnaire->fill($request->all());
        $questionnaire->save();

        return response()->json(["success" => [
            "message" => "Questionnaire updated",
        ]], 200);
    }

    /**
     * Deletes a questionnaire.
     *
     * @param integer $id - Id of questionnaire to delete
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete($id) {
        /** @var Questionnaire $questionnaire */
        $questionnaire = Questionnaire::find($id);

        // Check to see whether the current authenticated user owns the questionnaire
        // Only if they own it can they delete it
        if (Auth::id() != $questionnaire->user->id) {
            return response()->json(["error" => [
                "message" => "You do not own that questionnaire",
            ]], 401);
        }

        $questionnaire->delete();

        return response()->json(["success" => [
            "message" => "Questionnaire deleted",
        ]], 200);
    }

    /**
     * Returns all the questionnaires owned by the current authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all() {
        return response()->json(Auth::user()->questionnaires, 200);
    }

    /**
     * Gets the requested questionnaire.
     *
     * @param $id - Id of questionnaire to get
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($id) {
        $questionnaire = Questionnaire::find($id);

        if (Auth::id() != $questionnaire->user->id) {
            return response()->json(["error" => [
                "message" => "You do not own that questionnaire",
            ]], 401);
        }

        return response()->json(Questionnaire::find($id), 200);
    }

    /**
     * Returns a list of all the public & complete questionnaires.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function publicQuestionnaires() {
        return response()->json(Questionnaire::where("is_public", true)->where("is_complete", true)->get(), 200);
    }
}
