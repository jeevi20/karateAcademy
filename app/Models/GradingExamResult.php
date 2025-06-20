<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradingExamResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'student_id',
        'instructor_id',
        'result',
        'result_history',
        'result_entered_at',
    ];

    protected $casts = [
        'result_history' => 'array',
        'result_entered_at' => 'datetime',
    ];

    // Relationships
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }
}

