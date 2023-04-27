<?php

namespace Tests\Unit\Models;

use App\Models\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResponseTest extends TestCase
{
    use RefreshDatabase;

        /** @test */
        public function it_can_create_a_resonse()
        {
            $survey = $this->createTestSurvey();
            $question = $this->createTestQuestion($survey);
    
            $response = Response::create([
                'survey_id' => $survey->id,
                'question_id' => $question->id,
                'respondent_ident' => "TEST-ident",
                'answer' => "Long text test answer...."
            ]);
    
            $this->assertInstanceOf(Response::class, $response);
            $this->assertEquals($survey->id, $response->survey_id);
            $this->assertEquals($question->id, $response->question_id);
            $this->assertEquals('TEST-ident', $response->respondent_ident);
            $this->assertEquals(1, $question->type);
            $this->assertEquals($survey->id, $response->survey()->get()[0]->id);
            $this->assertEquals($question->id, $response->question()->get()[0]->id);
        }
}