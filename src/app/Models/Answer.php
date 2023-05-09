<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Access\AuthorizationException;

/**
 * @OA\Schema(
 *     schema="Answer",
 *     type="object",
 *     title="Answer",
 *     properties={
 *         @OA\Property(property="id", type="integer", format="int64"),
 *         @OA\Property(property="question_id", type="integer", format="int64"),
 *         @OA\Property(property="value", type="string"),
 *         @OA\Property(property="order", type="integer"),
 *         @OA\Property(property="created_at", type="string", format="date-time"),
 *         @OA\Property(property="updated_at", type="string", format="date-time"),
 *     },
 *     required={"question_id", "value", "order"},
 * )
 */


class Answer extends Model
{

    protected $table = 'answers';

    protected $fillable = ['question_id', 'value', 'order'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function update(array $attributes = [], array $options = [] ){
        if ($this->responses()->count() > 0){
            throw new AuthorizationException("Can not alter used answer");
        }

        return parent::update($attributes, $options);
    }

    public function delete(){
        if ($this->responses()->count() > 0){
            throw new AuthorizationException("Can not delete used answer");
        }
        return parent::delete();
    }
}
