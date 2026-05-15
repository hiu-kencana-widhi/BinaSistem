<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'student_id',
        'month',
        'year',
        'amount',
        'status',
        'snap_token',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
