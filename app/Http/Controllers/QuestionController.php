<?php

namespace App\Http\Controllers;

use App\Models\QuestionClosed;
use App\Models\QuestionClosedOption;
use App\Models\Questionnaire;
use App\Models\QuestionOpen;
use App\Models\QuestionScaled;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class QuestionController extends Controller {
    /**
     * Edits the details of a question.
     *
     * @param QuestionClosed | QuestionOpen | QuestionScaled $question
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    private function edit($question, $data) {
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
     * Duplicates a question from a questionnaire.
     *
     * @param QuestionClosed | QuestionOpen | QuestionScaled $question
     * @param int $newPosition - New position of the question.
     * @return \Illuminate\Http\JsonResponse
     */
    private function duplicate($question, $newPosition) {
        // Check to see whether the current authenticated user owns the questionnaire that the question belongs to
        // Only if they own it can they delete the question
        if (Auth::id() != $question->questionnaire->user->id) {
            return response()->json(["error" => [
                "message" => "You do not own that questionnaire, therefore you cannot duplicate a question",
            ]], 401);
        }

        // Copy the question and save it
        $duplicated = $question->replicate();
        $duplicated->position = $newPosition;
        $duplicated->save();

        return response()->json(["success" => [
            "message" => "Question duplicated",
        ]], 201);
    }

    /**
     * Delete a question from a questionnaire.
     *
     * @param QuestionClosed | QuestionOpen | QuestionScaled $question
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    private function delete($question) {
        // Check to see whether the current authenticated user owns the questionnaire that the question belongs to
        // Only if they own it can they delete the question
        if (Auth::id() != $question->questionnaire->user->id) {
            return response()->json(["error" => [
                "message" => "You do not own that questionnaire, therefore you cannot delete a question",
            ]], 401);
        }

        // Loop over all the other questions in the questionnaire
        // If they are after the current question, reduce its position by one as they have all moved back once position

        foreach ($question->questionnaire->openQuestions as $_question) {
            if ($_question->id > $question->id) {
                $_question->position -= 1;
                $_question->save();
            }
        }

        foreach ($question->questionnaire->closedQuestions as $_question) {
            if ($_question->id > $question->id) {
                $_question->position -= 1;
                $_question->save();
            }
        }

        foreach ($question->questionnaire->scaledQuestions as $_question) {
            if ($_question->id > $question->id) {
                $_question->position -= 1;
                $_question->save();
            }
        }

        $question->delete();

        return response()->json(["success" => [
            "message" => "Question deleted",
        ]], 200);
    }

    // _________________________________________________________________________________________________________________

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
     * Duplicates a question from a questionnaire.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function duplicateOpen(Request $request) {
        return $this->duplicate(QuestionOpen::find($request->input("question_id")), $request->input("position"));
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
     * Duplicates a question from a questionnaire.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function duplicateClosed(Request $request) {
        /** @var QuestionClosed $question */
        $question = QuestionClosed::find($request->input("question_id"));

        // Check to see whether the current authenticated user owns the questionnaire that the question belongs to
        // Only if they own it can they delete the question
        if (Auth::id() != $question->questionnaire->user->id) {
            return response()->json(["error" => [
                "message" => "You do not own that questionnaire, therefore you cannot duplicate a question",
            ]], 401);
        }

        /** @var QuestionClosed $duplicated */
        $duplicated = $question->replicate();
        $duplicated->position = $request->input("position");
        $duplicated->save();

        /** @var QuestionClosedOption $option */
        foreach ($question->options as $option) {
            // Copy the options for the question that is to be duplicated
            $duplicated->options()->save($option->replicate());
        }

        return response()->json(["success" => [
            "message" => "Question duplicated",
        ]], 201);
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
     * Duplicates a question from a questionnaire.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function duplicateScaled(Request $request) {
        return $this->duplicate(QuestionScaled::find($request->input("question_id")), $request->input("position"));
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
