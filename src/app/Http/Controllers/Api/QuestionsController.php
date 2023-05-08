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
     *
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
     *
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
     *
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