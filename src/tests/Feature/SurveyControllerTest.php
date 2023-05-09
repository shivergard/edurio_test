<?php

namespace Tests\Feature;

use App\Models\Survey;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class SurveyControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_all_active_surveys()
    {
        Survey::create([
            'title' => 'Survey 1',
            'description' => 'Description for Survey 1',
            'status' => true
        ]);

        Survey::create([
            'title' => 'Survey 2',
            'description' => 'Description for Survey 2',
            'status' => false
        ]);

        $response = $this->getJson('/api/surveys');

        $response->assertOk();
        $response->assertJsonCount(1);
        $response->assertJsonFragment([
            'title' => 'Survey 1',
            'description' => 'Description for Survey 1',
            'status' => 1
        ]);
    }

    public function test_show_returns_404_when_survey_not_found()
    {
        $response = $this->getJson('/api/surveys/999');

        $response->assertNotFound();
    }

    public function test_show_returns_no_content_when_survey_is_inactive()
    {
        $survey = Survey::create([
            'title' => 'Survey 1',
            'description' => 'Description for Survey 1',
            'status' => 0
        ]);

        $response = $this->getJson("/api/surveys/{$survey->id}");

        $response->assertNoContent();
    }

    public function test_show_returns_survey()
    {
        $survey = Survey::create([
            'title' => 'Survey 1',
            'description' => 'Description for Survey 1',
            'status' => 1
        ]);

        $response = $this->getJson("/api/surveys/{$survey->id}");

        $response->assertOk();
        $response->assertJsonFragment([
            'title' => 'Survey 1',
            'description' => 'Description for Survey 1',
            'status' => 1
        ]);
    }

    public function test_store_returns_created_survey()
    {
        $data = [
            'title' => 'Survey 1',
            'description' => 'Description for Survey 1',
            'status' => 1
        ];

        $response = $this->postJson('/api/surveys', $data);
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonFragment($data);

        $this->assertDatabaseHas('surveys', $data);
    }

    public function test_store_validates_required_fields()
    {
        $response = $this->postJson('/api/surveys');
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors([
            'title',
            'description',
            'status'
        ]);
    }

    public function test_update_updates_survey()
    {
        // Create a new survey
        $survey = Survey::create([
            'title' => 'Test Survey',
            'description' => 'This is a test survey',
            'status' => true,
        ]);
    
        // Define the updated survey data
        $updatedData = [
            'title' => 'Updated Test Survey',
            'description' => 'This is an updated test survey',
            'status' => false,
        ];
    
        // Send the update request with the updated survey data
        $response = $this->put('/api/surveys/' . $survey->id, $updatedData);
    
        // Assert that the response has the HTTP OK status code
        $response->assertOk();
    
        // Assert that the response has the updated survey data
        $response->assertJsonFragment($updatedData);
    
        // Refresh the survey model instance from the database
        $survey->refresh();
    
        // Assert that the survey model instance has the updated data
        $this->assertEquals($updatedData['title'], $survey->title);
        $this->assertEquals($updatedData['description'], $survey->description);
        $this->assertEquals($updatedData['status'], $survey->status);
    }
    
    public function test_delete_deletes_survey()
    {
        $survey = Survey::create([
            'title' => 'Test Survey',
            'description' => 'This is a test survey',
            'status' => true,
        ]);

        $response = $this->delete('/api/surveys/' . $survey->id, []);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertDatabaseMissing('surveys', ['id' => $survey->id, 'status' => 1]);
    }
}
