<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentClassroom extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'student_id',
        'classroom_id',
        'academic_year_id',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }
}
