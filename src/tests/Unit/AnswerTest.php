<?php

namespace Tests\Unit\Models;

use App\Models\Answer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnswerTest extends TestCase
{
    use RefreshDatabase;

        /** @test */
        public function it_can_create_a_answer()
        {
            $survey = $this->createTestSurvey();
            $question = $this->createTestQuestion($survey);

            $answer = Answer::create([
                'question_id' => $question->id,
                'value' => "TEST Answer",
                'order' => 5
            ]);

            $this->assertInstanceOf(Answer::class, $answer);
            $this->assertEquals($question->id, $answer->question_id);
            $this->assertEquals('TEST Answer', $answer->value);
            $this->assertEquals(5, $answer->order);
            $this->assertEquals($question->id, $answer->question()->get()[0]->id);
        }

        /** @test */
        public function it_can_update_a_answer()
        {
            $survey = $this->createTestSurvey();
            $question = $this->createTestQuestion($survey);

            $answer = Answer::create([
                'question_id' => $question->id,
                'value' => "TEST Answer",
                'order' => 5
            ]);

            $this->assertInstanceOf(Answer::class, $answer);

            $newQuestion = $this->createTestQuestion($survey);

            $answer->update([
                'question_id' => $newQuestion->id,
                'value' => "TEST Answer Update",
                'order' => 7
            ]);

            $this->assertEquals($newQuestion->id, $answer->question_id);
            $this->assertEquals('TEST Answer Update', $answer->value);
            $this->assertEquals(7, $answer->order);
            $this->assertEquals($newQuestion->id, $answer->question()->get()[0]->id);
        }

        /** @test */
        public function it_can_delete_a_answer()
        {
            $survey = $this->createTestSurvey();
            $question = $this->createTestQuestion($survey);

            $answer = Answer::create([
                'question_id' => $question->id,
                'value' => "TEST Answer",
                'order' => 5
            ]);

            $this->assertInstanceOf(Answer::class, $answer);

            $answerId = $answer->id;

            $answer->delete();

            $answerResponse = Answer::where('id', $answerId);
            $this->assertEquals(0, $answerResponse->count());
        }

        //can not delete if has responses
        //can not update if has responses
}
