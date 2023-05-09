<?php

namespace Tests\Feature;

use App\Http\Controllers\QuestionsController;
use App\Http\Requests\CreateQuestionRequest;
use App\Models\Question;
use App\Models\Survey;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_questions_for_active_survey()
    {

    }

    public function test_index_returns_404_for_inactive_survey()
    {

    }

    public function test_store_creates_new_question_for_active_survey()
    {

    }

    public function test_store_returns_404_for_inactive_survey()
    {

    }

}
