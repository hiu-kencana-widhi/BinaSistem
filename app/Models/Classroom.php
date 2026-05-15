<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'major_id',
        'name',
        'level',
        'teacher_id_walikelas',
    ];

    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id_walikelas');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'student_classrooms', 'classroom_id', 'student_id')
                    ->withPivot('academic_year_id')
                    ->withTimestamps();
    }

    public function studentClassrooms()
    {
        return $this->hasMany(StudentClassroom::class, 'classroom_id');
    }
}
