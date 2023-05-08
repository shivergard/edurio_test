<?php

namespace App\Http\Controllers\Api;

use App\Models\Survey;
use Illuminate\Http\Request;
use App\Http\Requests\CreateSurveyRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $surveys = Survey::where('status', 1)->get();

        return response()->json($surveys);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSurveyRequest $request)
    {
        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 422);
        // }

        $survey = Survey::create($request->all());

        return response()->json($survey, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show(Survey $survey)
    {
        if ($survey->status == 0){
            return response()->json(null, Response::HTTP_NO_CONTENT); 
        }
        return response()->json($survey);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Survey $survey)
    {
        $survey->update($request->all());

        return response()->json($survey);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function delete(Survey $survey)
    {
        $survey->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
