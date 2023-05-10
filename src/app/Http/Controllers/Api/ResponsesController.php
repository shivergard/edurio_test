<?php

namespace App\Http\Controllers\Api;

use App\Models\Question;
use App\Models\Answers;
use App\Models\Response as UserResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CreateUserResponseRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

/**
 * @OA\Tag(
 *     name="Responses",
 *     description="API endpoints for managing user responses to survey questions"
 * )
 */

class ResponsesController {

    /**
     * @OA\Get(
     *     path="/api/question/{question}/responses",
     *     summary="Get responses for a question",
     *     description="Get all responses for a given question",
     *     operationId="getResponsesForQuestion",
     *     tags={"Responses"},
     *     @OA\Parameter(
     *         name="question",
     *         in="path",
     *         description="ID of the question to get responses for",
     *         required=true,
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Response")
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Question not found"
     *     )
     * )
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Question $question)
    {
        if (!$question->isActive())
        {
            return response()->json(null, 404);
        }
        $questions = $question
                        ->responses()
                        ->get();

        return response()->json($questions);
    }

    /**
     * @OA\Post(
     *     path="/api/question/{question}/responses",
     *     summary="Create a response for a question",
     *     description="Create a new response for a given question",
     *     operationId="createResponseForQuestion",
     *     tags={"Responses"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="question",
     *         in="path",
     *         description="ID of the question to create a response for",
     *         required=true,
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data for creating a new response",
     *         @OA\JsonContent(ref="#/components/schemas/CreateUserResponseRequest")
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Success",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/Response"
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Question not found"
     *     )
     * )
     * 
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question, CreateUserResponseRequest $request)
    {
        if (!$question->isActive())
        {
            return response()->json(null, 404);
        }

        $question = UserResponse::create(
            array_merge(
                [
                    'question_id' => $question->id,
                    'survey_id' => $question->survey()->first()->id
                ],
                $request->all()
            )
        );

        return response()->json($question, Response::HTTP_CREATED);
    }
    
}