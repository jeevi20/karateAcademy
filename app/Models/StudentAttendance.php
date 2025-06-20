<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentAttendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'student_attendance';

    protected $fillable = ['student_id', 'schedule_id', 'event_id', 'status', 'date','recorded_by'];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

 

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
