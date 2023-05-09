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
        // Create a new survey
        $survey = Survey::create([
            'title' => 'Test Survey',
            'description' => 'Test Description',
            'status' => true
        ]);

        // Create questions for the survey
        $question1 = $survey->questions()->create([
            'text' => 'Test Question 1',
            'type' => 1
        ]);

        $question2 = $survey->questions()->create([
            'text' => 'Test Question 2',
            'type' => 2
        ]);

        // Create inactive survey and questions
        $inactiveSurvey = Survey::create([
            'title' => 'Inactive Survey',
            'description' => 'Inactive Description',
            'status' => 0
        ]);

        $inactiveQuestion = $inactiveSurvey->questions()->create([
            'text' => 'Inactive Question',
            'type' => 5
        ]);

        // Make a request to the controller
        $response = $this->get('/api/surveys/' . $survey->id . '/questions');

        // Assert that the response has a 200 status code
        $response->assertStatus(200);

        // Assert that the response contains the correct questions
        $response->assertJson([
            [
                'id' => $question1->id,
                'survey_id' => $survey->id,
                'text' => $question1->text,
                'type' => $question1->type,
            ],
            [
                'id' => $question2->id,
                'survey_id' => $survey->id,
                'text' => $question2->text,
                'type' => $question2->type,
            ],
        ]);

        // Assert that the response does not contain questions for the inactive survey
        $response->assertJsonMissing([
            'id' => $inactiveQuestion->id,
            'survey_id' => $inactiveSurvey->id,
            'text' => $inactiveQuestion->text,
            'type' => $inactiveQuestion->type,
        ]);
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
