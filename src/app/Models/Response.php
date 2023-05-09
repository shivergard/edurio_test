<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Question",
 *     type="object",
 *     title="Question",
 *     properties={
 *         @OA\Property(property="id", type="integer", format="int64"),
 *         @OA\Property(property="survey_id", type="integer", format="int64"),
 *         @OA\Property(property="text", type="string"),
 *         @OA\Property(property="type", type="integer"),
 *     },
 *     required={"survey_id", "text", "type"},
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
