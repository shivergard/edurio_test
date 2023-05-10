<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Survey;

class AnswersControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_answers_for_active_question()
    {
        // Create a survey and an active question with two answers
        $survey = Survey::create([
            'title' => 'Survey 1',
            'description' => 'Description for Survey 1',
            'status' => true
        ]);
    
        $question = Question::create([
            'text' => 'What is your name?',
            'active' => true,
            'type' => 1,
            'survey_id' => $survey->id
        ]);
    
        $answer1 = Answer::create([
            'value' => 'John',
            'order' => 1,
            'question_id' => $question->id,
            'survey_id' => $survey->id
        ]);
    
        $answer2 = Answer::create([
            'value' => 'Jane',
            'order' => 2,
            'question_id' => $question->id,
            'survey_id' => $survey->id
        ]);
    
        // Make a GET request to the index() method for the active question
        $response = $this->get("/api/question/{$question->id}/answers");
    
        // Assert that the response status code is 200 OK
        $response->assertStatus(200);
    
        // Assert that the response body contains both answers' values
        $response->assertSee($answer1->value);
        $response->assertSee($answer2->value);
    }
    
    public function test_index_returns_404_for_inactive_question()
    {
        // Create a survey and an inactive question
        $survey = Survey::create([
            'title' => 'Survey 1',
            'description' => 'Description for Survey 1',
            'status' => 0
        ]);
    
        $question = Question::create([
            'text' => 'What is your name?',
            'type' => 1,
            'survey_id' => $survey->id
        ]);
    
        // Make a GET request to the index() method for the inactive question
        $response = $this->get("/api/question/{$question->id}/answers");
    
        // Assert that the response status code is 404 Not Found
        $response->assertStatus(404);
    }
    
    public function test_store_creates_new_answer_for_active_question()
    {
        // Create a survey and an active question
        $survey = Survey::create([
            'title' => 'Survey 1',
            'description' => 'Description for Survey 1',
            'status' => true
        ]);
    
        $question = Question::create([
            'text' => 'What is your name?',
            'active' => true,
            'type' => 1,
            'survey_id' => $survey->id
        ]);
    
        // Make a POST request to the store() method with a new answer's value
        $response = $this->post("/api/question/{$question->id}/answer", [
            'value' => 'John',
            'order' => 1
        ]);
    
        // Assert that the response status code is 201 Created
        $response->assertStatus(201);
    
        // Assert that the new answer was created in the database
        $this->assertDatabaseHas('answers', [
            'value' => 'John',
            'question_id' => $question->id
        ]);
    }

    public function test_show()
    {
        $survey = Survey::create([
            'title' => 'Survey 1',
            'description' => 'Description for Survey 1',
            'status' => true
        ]);
        // Create a question and answer
        $question = Question::create([
            'text' => 'What is your name?',
            'active' => true,
            'type' => 1,
            'survey_id' => $survey->id
        ]);

        $answer = Answer::create([
            'value' => 'John',
            'order' => 1,
            'question_id' => $question->id,
            'survey_id' => $survey->id
        ]);

        // Make a GET request to the show() method
        $response = $this->get("/api/question/{$question->id}/answer/{$answer->id}");

        // Assert that the response status code is 200 OK
        $response->assertStatus(200);

        // Assert that the response body contains the answer's value
        $response->assertSee($answer->value);
    }

    public function test_delete()
    {
        $survey = Survey::create([
            'title' => 'Survey 1',
            'description' => 'Description for Survey 1',
            'status' => true
        ]);
        // Create a question and answer
        $question = Question::create([
            'text' => 'What is your name?',
            'active' => true,
            'type' => 1,
            'survey_id' => $survey->id
        ]);

        $answer = Answer::create([
            'value' => 'John',
            'order' => 1,
            'question_id' => $question->id,
            'survey_id' => $survey->id
        ]);

        // Make a DELETE request to the delete() method
        $response = $this->delete("/api/question/{$question->id}/answer/{$answer->id}");

        // Assert that the response status code is 204 No Content
        $response->assertStatus(204);

        // Assert that the answer was deleted from the database
        $this->assertDatabaseMissing('answers', [
            'id' => $answer->id,
        ]);
    }
}

