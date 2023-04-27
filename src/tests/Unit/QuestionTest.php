<?php

namespace Tests\Unit\Models;

use App\Models\Survey;
use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_question()
    {
        $survey = $this->createTestSurvey();

        $question = Question::create([
            'survey_id' => $survey->id,
            'text' => "Sample Question",
            'type' => 1
        ]);

        $this->assertInstanceOf(Question::class, $question);
        $this->assertEquals($survey->id, $question->survey_id);
        $this->assertEquals('Sample Question', $question->text);
        $this->assertEquals(1, $question->type);
        $this->assertEquals($survey->id, $question->survey()->get()[0]->id);
    }

    private function createTestSurvey()
    {
        $survey = Survey::create([
            'title' => 'Question Test Survey',
            'description' => 'This is a question test survey',
            'status' => 1
        ]);

        return $survey;
    }

}