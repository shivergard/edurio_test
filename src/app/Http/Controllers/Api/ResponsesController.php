<?php

namespace App\Http\Controllers\Api;

use App\Models\Question;
use App\Models\Answers;
use App\Models\Response as UserResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CreateQuestionRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class ResponsesController {

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
                        ->responses()
                        ->get();

        return response()->json($questions);
    }
    
}