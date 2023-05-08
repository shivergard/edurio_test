<?php

namespace App\Http\Controllers\Api;

use App\Models\Survey;
use App\Models\Question;
use App\Models\Answer;

use Illuminate\Http\Request;
use App\Http\Requests\CreateAnswerRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class AnswersController {

    /**
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