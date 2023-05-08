<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;

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
            throw Exception("Can not alter ongoing question");
        }

        return parent::update($attributes, $options);
    }

    public function delete(){
        if ($this->responses()->count() > 0){
            throw Exception("Can not delete ongoing question");
        }
        return parent::delete();
    }

    public function isActive()
    {
        $survey = $this->survey()->first();
        return $survey->status === 1;
    }
}
