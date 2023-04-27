<?php

namespace Tests\Unit\Models;

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

    /** @test */
    public function it_can_update_a_question()
    {
        $survey = $this->createTestSurvey();

        $question = Question::create([
            'survey_id' => $survey->id,
            'text' => "Sample Question",
            'type' => 1
        ]);

        $this->assertInstanceOf(Question::class, $question);

        $newSurvey = $this->createTestSurvey();

        $question->update([
            'survey_id' => $newSurvey->id,
            'text' => "Sample Updated Question",
            'type' => 0
        ]);

        $this->assertEquals($newSurvey->id, $question->survey_id);
        $this->assertEquals('Sample Updated Question', $question->text);
        $this->assertEquals(0, $question->type);
        $this->assertEquals($newSurvey->id, $question->survey()->get()[0]->id);
    }

    /** @test */
    public function it_can_delete_a_question()
    {
        $survey = $this->createTestSurvey();

        $question = Question::create([
            'survey_id' => $survey->id,
            'text' => "Sample Question",
            'type' => 1
        ]);

        $this->assertInstanceOf(Question::class, $question);

        $questionId = $question->id;

        $question->delete();

        $questionResponse = Question::where('id', $questionId);
        $this->assertEquals(0, $questionResponse->count());
    }

}