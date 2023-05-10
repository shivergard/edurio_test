<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Response",
 *     type="object",
 *     title="Response",
 *     properties={
 *         @OA\Property(property="id", type="integer", format="int64"),
 *         @OA\Property(property="question_id", type="integer", format="int64"),
 *         @OA\Property(property="survey_id", type="integer", format="int64"),
 *         @OA\Property(property="respondent_ident", type="string"),
 *         @OA\Property(property="answer", type="string"),
 *         @OA\Property(property="created_at", type="string", format="date-time"),
 *         @OA\Property(property="updated_at", type="string", format="date-time"),
 *     },
 *     required={"question_id", "survey_id", "respondent_ident", "answer"},
 * )
 */


class Response extends Model
{

    protected $fillable = [
        'survey_id',
        'question_id',
        'respondent_ident',
        'answer_id',
        'answer',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
