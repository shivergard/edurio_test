<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Survey",
 *     type="object",
 *     title="Survey",
 *     properties={
 *         @OA\Property(property="id", type="integer", format="int64"),
 *         @OA\Property(property="title", type="string"),
 *         @OA\Property(property="description", type="string"),
 *         @OA\Property(property="status", type="boolean"),
 *     },
 *     required={"title", "description", "status"},
 * )
 */

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

    public static function active()
    {
        return self::where('status', 1);
    }

    public function isActive()
    {
        return $this->status === 1;
    }

    public function delete(){
        $this->update([
            'status' => 0
        ]);
    }
}
