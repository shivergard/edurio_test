<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\Question;
use App\Models\Survey;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp() :void {
        parent::setUp();
    }

    protected function createTestSurvey() : Survey
    {
        $survey = Survey::create([
            'title' => 'Question Test Survey',
            'description' => 'This is a question test survey',
            'status' => 1
        ]);

        return $survey;
    }

    protected function createTestQuestion(Survey $survey) : Question
    {
        $question = Question::create([
            'survey_id' => $survey->id,
            'text' => "Sample Question",
            'type' => 1
        ]);

        $this->assertInstanceOf(Question::class, $question);

        return $question;
    }
}
