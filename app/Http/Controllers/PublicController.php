<?php

namespace App\Http\Controllers;

use App\Http\Resources\AnswerableQuestionnaireResource;
use App\Models\{QuestionClosed,
    QuestionClosedOption,
    Questionnaire,
    QuestionnaireCategory,
    QuestionOpen,
    QuestionScaled};
use Illuminate\Http\Request;

class PublicController extends Controller {
    /**
     * Returns the categories available for a questionnaire.
     */
    public function categories() {
        return response()->json(QuestionnaireCategory::all(), 200);
    }

    /**
     * Returns a list of all the public & complete questionnaires.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function publicQuestionnaires() {
        // TODO: Check date as well

        return response()->json(
            Questionnaire::where("is_public", true)
                ->where("is_complete", true)
                //->whereDate("expiry_date", ">", Carbon::now()) // NOTE: Needs more advanced query
                ->get(),
            200);
    }

    /**
     * Returns a the requested questionnaire if it public and complete.
     *
     * @param $id - ID of questionnaire
     * @return \Illuminate\Http\JsonResponse
     */
    public function answerQuestionnaire($id) {
        /** @var Questionnaire $questionnaire */
        $questionnaire = Questionnaire::where("id", $id)
            ->with(["closedQuestions", "closedQuestions.options", "scaledQuestions", "openQuestions"])
            ->first();

        if (!$questionnaire->is_complete) {
            return response()->json(["error" =>[
                "message" => "You cannot access that questionnaire",
            ]], 401);
        }

        return response()->json(["success" => [
            "questionnaire" => $questionnaire
        ]], 200);
    }

    /**
     * Submits a questionnaire and saves its responses.
     *
     * @param Request $request
     * @param $id - Questionnaire ID.
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitQuestionnaire(Request $request, $id) {
        /** @var Questionnaire $questionnaire */
        $questionnaire = Questionnaire::find($id);

        if (!$questionnaire->is_public && !$questionnaire->is_complete) {
            return response()->json(["error" =>[
                "message" => "You cannot answer this questionnaire",
            ]], 401);
        }

        /**
         * Checks if a required question id exists in the answers array.
         *
         * @param int $questionId - Question id.
         * @param array $answers - Array of answers.
         * @return bool - Returns true if it exists, false if not.
         */
        $checkIdExists = function ($questionId, $answers) {
            $values = [];

            foreach ($answers as $question) {
                $values[] = $question["id"];
            }

            return in_array($questionId, $values);
        };

        /**
         * Gets the response for the given question.
         *
         * @param int $id - ID of question to get response for.
         * @param array $answers - List of answers to find response in.
         * @param bool $isClosedQuestion - If true then the list of responses are from closed questions.
         * @return array|string|int|null - Returns the response for the given question or null if it is not found
         */
        $getQuestionAnswer = function ($id, $answers, $isClosedQuestion = false) {
            foreach ($answers as $answer) {
                if ($answer["id"] === $id)
                    return $isClosedQuestion ? $answer["options"] : $answer["response"];
            }
            return null;
        };

        /** @var QuestionOpen $openQuestion */
        foreach ($questionnaire->openQuestions as $openQuestion) {
            // Check whether the current question has an answer
            if (!$checkIdExists($openQuestion->id, $request->input("open"))) {
                // If the current question doesn't have an answer and it is required return an error
                if ($openQuestion->is_required) {
                    return response()->json(["error" => [
                        "message" => "Required questions are missing",
                    ]], 400);
                }
            } else {
                // Get the answer for the current question
                $answer = $getQuestionAnswer($openQuestion->id, $request->input("open"));

                $openQuestion->responses()->create([
                    "response" => $answer
                ]);
            }
        }

        /** @var QuestionClosed $closedQuestion */
        foreach ($questionnaire->closedQuestions as $closedQuestion) {
            // Check whether the current question has an answer
            if (!$checkIdExists($closedQuestion->id, $request->input("closed"))) {
                // If the current question doesn't have an answer and it is required return an error
                if ($closedQuestion->is_required) {
                    return response()->json(["error" => [
                        "message" => "Required questions are missing",
                    ]], 400);
                }
            } else {
                // Get the answer for the current question
                $answers = $getQuestionAnswer($closedQuestion->id, $request->input("closed"), true);

                foreach ($answers as $optionId) {
                    /** @var QuestionClosedOption $option */
                    $option = QuestionClosedOption::find($optionId);

                    $option->responses += 1;
                    $option->save();
                }
            }
        }

        /** @var QuestionScaled $scaledQuestion */
        foreach ($questionnaire->scaledQuestions as $scaledQuestion) {
            // Check whether the current question has an answer
            if (!$checkIdExists($scaledQuestion->id, $request->input("scaled"))) {
                // If the current question doesn't have an answer and it is required return an error
                if ($scaledQuestion->is_required) {
                    return response()->json(["error" => [
                        "message" => "Required questions are missing",
                    ]], 400);
                }
            } else {
                // Get the answer for the current question
                $answer = $getQuestionAnswer($scaledQuestion->id, $request->input("scaled"));

                $scaledQuestion->responses()->create([
                    "response" => $answer
                ]);
            }
        }

        $questionnaire->responses += 1;
        $questionnaire->save();

        return response()->json(["success" => [
            "message" => "Response saved",
        ]], 201);
    }
}
