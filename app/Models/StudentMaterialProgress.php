<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentMaterialProgress extends Model
{
    protected $table = 'student_material_progress';
    
    protected $fillable = [
        'student_id',
        'material_id',
        'is_read',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
}
