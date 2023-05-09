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

    public function testDelete()
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

