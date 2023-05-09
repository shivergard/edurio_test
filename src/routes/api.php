<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SurveyController;
use App\Http\Controllers\Api\QuestionsController;
use App\Http\Controllers\Api\AnswersController;
use App\Http\Controllers\Api\ResponsesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//Surveys
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/surveys', [SurveyController::class, 'store']);
    Route::put('/surveys/{survey}', [SurveyController::class, 'update']);
    Route::delete('/surveys/{survey}', [SurveyController::class, 'delete']);
});

Route::get('/surveys', [SurveyController::class, 'index']);
Route::get('/surveys/{survey}', [SurveyController::class, 'show']);

//Questions
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/surveys/{survey}/questions', [QuestionsController::class, 'store']);
    Route::put('/surveys/{survey}/questions/{question}', [QuestionsController::class, 'update']);
    Route::delete('/surveys/{survey}/questions/{question}', [QuestionsController::class, 'delete']);
});

Route::get('/surveys/{survey}/questions', [QuestionsController::class, 'index']);
Route::get('/surveys/{survey}/questions/{question}', [QuestionsController::class, 'show']);

//Awnswers
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/question/{question}/answer', [AnswersController::class, 'store']);
    Route::put('/question/{question}/answer/{answer}', [AnswersController::class, 'update']);
    Route::delete('/question/{question}/answer/{answer}', [AnswersController::class, 'delete']);
});

Route::get('/question/{question}/answers', [AnswersController::class, 'index']);
Route::get('/question/{question}/answer/{answer}', [AnswersController::class, 'show']);

//Responses
Route::middleware('auth:sanctum')->group(function () {
    // guess no altering of responses
    // Route::put('/question/{question}/answer/{answer}', [AnswersController::class, 'update']);
    // no delete of responses
    // Route::delete('/question/{question}/answer/{answer}', [AnswersController::class, 'delete']);
    Route::get('/question/{question}/responses', [ResponsesController::class, 'index']);
    Route::get('/question/{question}/response/{answer}', [ResponsesController::class, 'show']);
});

Route::post('/question/{question}/response', [ResponsesController::class, 'store']);