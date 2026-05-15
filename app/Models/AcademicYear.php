<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'year',
        'semester_type',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function studentClassrooms()
    {
        return $this->hasMany(StudentClassroom::class, 'academic_year_id');
    }
}
