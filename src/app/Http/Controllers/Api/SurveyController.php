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
     * @OA\Get(
     *     path="/surveys",
     *     summary="Get all surveys",
     *     description="Get all surveys that have status=1",
     *     operationId="getSurveys",
     *     tags={"Surveys"},
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Survey")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $surveys = Survey::where('status', 1)->get();

        return response()->json($surveys);
    }

    /**
     * @OA\Post(
     *     path="/surveys",
     *     summary="Create a new survey",
     *     description="Create a new survey",
     *     operationId="createSurvey",
     *     tags={"Surveys"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         description="Survey object to be created",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SurveyRequest")
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Created",
     *         @OA\JsonContent(ref="#/components/schemas/Survey")
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Unprocessable Entity"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthenticated"
     *     )
     * )
     */
    public function store(CreateSurveyRequest $request)
    {
        $validatedData = $request->validated();
        if (!is_array($validatedData) && $validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()], 422);
        }

        $survey = Survey::create($request->all());
        return response()->json($survey, Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *     path="/surveys/{survey}",
     *     summary="Get a survey by ID",
     *     description="Get a survey by ID",
     *     operationId="getSurveyById",
     *     tags={"Surveys"},
     *     @OA\Parameter(
     *         name="survey",
     *         in="path",
     *         description="ID of the survey to retrieve",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Survey")
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="No Content"
     *     ),
     * )
     */
    public function show(Survey $survey)
    {
        if ($survey->status == 0){
            return response()->json(null, Response::HTTP_NO_CONTENT); 
        }
        return response()->json($survey);
    }

    /**
     * @OA\Put(
     *     path="/surveys/{survey}",
     *     summary="Update an existing survey",
     *     description="Update an existing survey",
     *     operationId="updateSurvey",
     *     tags={"Surveys"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="survey",
     *         in="path",
     *         description="ID of the survey to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Survey object to be updated",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SurveyRequest")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Survey")
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthenticated"
     *     )
     * )
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
     * @OA\Put(
     *     path="/surveys/{survey}",
     *     summary="Update an existing survey",
     *     description="Update an existing survey",
     *     operationId="updateSurvey",
     *     tags={"Surveys"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="survey",
     *         in="path",
     *         description="ID of the survey to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Survey object to be updated",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SurveyRequest")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Survey")
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthenticated"
     *     )
     * )
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function delete(Survey $survey)
    {
        $survey->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
