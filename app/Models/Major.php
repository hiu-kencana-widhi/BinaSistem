<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'code',
        'name',
    ];

    public function classrooms()
    {
        return $this->hasMany(Classroom::class, 'major_id');
    }
}
