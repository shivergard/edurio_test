<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Access\AuthorizationException;
/**
 * @OA\Schema(
 *     schema="Question",
 *     type="object",
 *     title="Question",
 *     properties={
 *         @OA\Property(property="id", type="integer", format="int64"),
 *         @OA\Property(property="survey_id", type="integer", format="int64"),
 *         @OA\Property(property="text", type="string"),
 *         @OA\Property(property="type", type="integer", format="int64"),
 *     },
 *     required={"title", "description", "active"},
 * )
 */

class Question extends Model
{
    protected $table = 'questions';

    protected $fillable = [
        'survey_id',
        'text',
        'type'
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function responses(){
        return $this->hasMany(Response::class);
    }

    public function update(array $attributes = [], array $options = [] ){
        if ($this->responses()->count() > 0){
            throw new AuthorizationException("Can not alter ongoing question");
        }

        return parent::update($attributes, $options);
    }

    public function delete(){
        if ($this->responses()->count() > 0){
            throw new AuthorizationException("Can not delete ongoing question");
        }
        return parent::delete();
    }

    public function isActive()
    {
        $survey = $this->survey()->first();
        return $survey->status === 1;
    }
}
