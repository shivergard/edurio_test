<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
            throw Exception("Can not alter used answer");
        }

        return parent::update($attributes, $options);
    }

    public function delete(){
        if ($this->responses()->count() > 0){
            throw Exception("Can not delete used answer");
        }
        return parent::delete();
    }
}
