<?php

namespace Tests\Unit\Models;

use App\Models\Survey;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SurveyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_survey()
    {
        $survey = Survey::create([
            'title' => 'Test Survey',
            'description' => 'This is a test survey',
            'status' => 1
        ]);

        $this->assertInstanceOf(Survey::class, $survey);
        $this->assertEquals('Test Survey', $survey->title);
        $this->assertEquals('This is a test survey', $survey->description);
        $this->assertEquals(1, $survey->status);
    }

    /** @test */
    public function it_can_update_a_survey()
    {
        $survey = Survey::create([
            'title' => 'Test Survey',
            'description' => 'This is a test survey',
            'status' => 1
        ]);

        $survey->update([
            'title' => 'Updated Title',
            'description' => 'This is an updated description',
            'status' => 0
        ]);

        $this->assertInstanceOf(Survey::class, $survey);
        $this->assertEquals('Updated Title', $survey->title);
        $this->assertEquals('This is an updated description', $survey->description);
        $this->assertEquals(0, $survey->status);
    }

    // active test
    // is active test
}
