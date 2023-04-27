<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{

    protected $fillable = [
        'title',
        'description',
        'status'
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public static function active(){
        return self::where('status', 1);
    }
}
