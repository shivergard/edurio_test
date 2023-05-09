<?php

namespace App\Http\Controllers\Api;

use App\Models\Survey;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Requests\CreateQuestionRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class QuestionsController {

    /**
     * @OA\Tag(
     *     name="Questions",
     *     description="API Endpoints for managing questions"
     * )
     *
     * @OA\Get(
     *     path="/api/surveys/{survey}/questions",
     *     summary="Get all questions for a survey",
     *     tags={"Questions"},
     *     @OA\Parameter(
     *         name="survey",
     *         in="path",
     *         description="ID of the survey to retrieve questions for",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Question")
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not found"
     *     )
     * )
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Survey $survey)
    {
        if (!$survey->isActive())
        {
            return response()->json(null, 404);
        }
        $questions = $survey
                        ->questions()
                        ->get();

        return response()->json($questions);
    }

    /**
     * Store a newly created resource in storage.
     * @OA\Post(
     *     path="/api/surveys/{survey}/questions",
     *     summary="Create a new question for a survey",
     *     tags={"Questions"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="survey",
     *         in="path",
     *         description="ID of the survey to add the question to",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Question object that needs to be created",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateQuestionRequest")
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Question")
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not found"
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Validation error"
     *     ),
     * )
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Survey $survey, CreateQuestionRequest $request)
    {
        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 422);
        // }
        if (!$survey->isActive())
        {
            return response()->json(null, 404);
        }

        $question = Question::create(
            array_merge(
                ['survey_id' => $survey->id],
                $request->all()
            )
        );

        return response()->json($question, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     * @OA\Put(
     *     path="/api/surveys/{survey}/questions/{question}",
     *     summary="Update an existing question",
     *     tags={"Questions"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="survey",
     *         in="path",
     *         description="ID of the survey that the question belongs to",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="question",
     *         in="path",
     *         description="ID of the question to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Question object that needs to be updated",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Question")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Question")
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not found"
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Validation error"
     *     ),
     * )
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Survey $survey, Question $question)
    {
        if (
            !$survey->isActive() ||
            $survey->id !== $question->survey_id
        ) {
            return response()->json(null, 404);
        }

        $question->update($request->all());
        return response()->json($question);
    }

    /**
     * Remove the specified resource from storage.
     * @OA\Delete(
     *     path="/api/surveys/{survey}/questions/{question}",
     *     summary="Delete a question",
     *     description="Delete a question from a survey if the survey is active and the question belongs to the survey",
     *     operationId="deleteQuestion",
     *     security={{"sanctum":{}}},
     *     tags={"Questions"},
     *     @OA\Parameter(
     *         name="survey",
     *         in="path",
     *         description="ID of the survey to delete the question from",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="question",
     *         in="path",
     *         description="ID of the question to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="No content",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *         @OA\JsonContent()
     *     )
     * )

     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function delete(Survey $survey, Question $question)
    {
        if (
            !$survey->isActive() ||
            $survey->id !== $question->survey_id
        ) {
            return response()->json(null, 404);
        }

        $question->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
    
    
}