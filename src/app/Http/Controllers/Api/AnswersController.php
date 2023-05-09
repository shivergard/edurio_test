<?php

namespace App\Http\Controllers\Api;

use App\Models\Survey;
use App\Models\Question;
use App\Models\Answer;

use Illuminate\Http\Request;
use App\Http\Requests\CreateAnswerRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

/**
 * @OA\Tag(name="Answers")
 *
 * Class AnswersController
 * @package App\Http\Controllers
 */
class AnswersController {

    /**
     * @OA\Get(
     *     path="/questions/{question}/answers",
     *     summary="Get all answers for a question",
     *     description="Get all answers for a given question if it is active",
     *     operationId="getAnswers",
     *     tags={"Answers"},
     *     @OA\Parameter(
     *         name="question",
     *         in="path",
     *         description="ID of the question",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Answer")
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found"
     *     )
     * )

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
                        ->answers()
                        ->get();

        return response()->json($questions);
    }

    /**
     * @OA\Post(
     *     path="/questions/{question}/answers",
     *     summary="Create a new answer for a question",
     *     description="Create a new answer for a given question if it is active",
     *     operationId="createAnswer",
     *     tags={"Answers"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="question",
     *         in="path",
     *         description="ID of the question",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateAnswerRequest")
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Created",
     *         @OA\JsonContent(ref="#/components/schemas/Answer")
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found"
     *     )
     * )
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question, CreateAnswerRequest $request)
    {
        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 422);
        // }
        if (!$question->isActive())
        {
            return response()->json(null, 404);
        }

        $question = Answer::create(
            array_merge(
                ['question_id' => $question->id],
                $request->all()
            )
        );

        return response()->json($question, Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *     path="/questions/{question}/answers/{answer}",
     *     summary="Show a single answer",
     *     description="Retrieve the details of a single answer",
     *     operationId="showAnswer",
     *     tags={"Answers"},
     *     @OA\Parameter(
     *         name="question",
     *         in="path",
     *         description="ID of the question that the answer belongs to",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="answer",
     *         in="path",
     *         description="ID of the answer to retrieve",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/Answer"
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found"
     *     )
     * )
     * Display the specified resource.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question, Answer $answer)
    {
        if (
            !$question->isActive() ||
            $question->id !== $answer->question_id
            ){
            return response()->json(null, 404); 
        }

        return response()->json($answer);
    }

    /**
     * @OA\Delete(
     *     path="/questions/{question}/answers/{answer}",
     *     summary="Delete an answer",
     *     description="Delete a single answer",
     *     operationId="deleteAnswer",
     *     security={{"sanctum":{}}},
     *     tags={"Answers"},
     *     @OA\Parameter(
     *         name="question",
     *         in="path",
     *         description="ID of the question that the answer belongs to",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="answer",
     *         in="path",
     *         description="ID of the answer to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="No Content"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found"
     *     )
     * )
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function delete(Question $question, Answer $answer)
    {
        if (
            !$question->isActive() ||
            $question->id !== $answer->question_id
            ){
            return response()->json(null, 404); 
        }
        $answer->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

}