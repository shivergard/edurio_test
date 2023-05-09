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
        // Create a survey
        $survey = Survey::create([
            'title' => 'Test Survey',
            'description' => 'This is a test survey.',
            'status' => false,
        ]);
    
        // Create some questions for the survey
        $questions = [
            [
                'text' => 'Question 1',
                'type' => 1,
            ],
            [
                'text' => 'Question 2',
                'type' => 2,
            ],
            [
                'text' => 'Question 3',
                'type' => 1,
            ],
        ];
        foreach ($questions as $question) {
            $survey->questions()->create($question);
        }
    
        // Send a GET request to the index endpoint with the survey ID
        $response = $this->get('/surveys/' . $survey->id . '/questions');
    
        // Assert that the response status code is 404
        $response->assertStatus(404);
    }
    

    public function test_store_creates_new_question_for_active_survey()
    {
        // Create a new survey
        $survey = Survey::create([
            'title' => 'New Survey',
            'description' => 'This is a new survey.',
            'status' => 1,
        ]);
    
        // Make a POST request to the store endpoint with new question data
        $response = $this->post("/api/surveys/{$survey->id}/questions", [
            'text' => 'What is your favorite color?',
            'type' => 1,
        ]);
    
        // Assert that the response is successful
        $response->assertStatus(Response::HTTP_CREATED);
    
        // Assert that the question was created and saved to the database
        $this->assertDatabaseHas('questions', [
            'survey_id' => $survey->id,
            'text' => 'What is your favorite color?',
            'type' => 1,
        ]);
    }
    

    public function test_store_returns_404_for_inactive_survey()
    {
        // Create a new inactive survey
        $survey = Survey::create([
            'title' => 'New Survey',
            'description' => 'This is a new survey.',
            'status' => 0, // inactive
        ]);
    
        // Make a POST request to the store endpoint with new question data
        $response = $this->post("/surveys/{$survey->id}/questions", [
            'text' => 'What is your favorite color?',
            'type' => 1,
        ]);
    
        // Assert that the response is not successful and returns a 404 status code
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    
        // Assert that the question was not created and saved to the database
        $this->assertDatabaseMissing('questions', [
            'survey_id' => $survey->id,
            'text' => 'What is your favorite color?',
            'type' => 1,
        ]);
    }    

}
