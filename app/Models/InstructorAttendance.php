<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstructorAttendance extends Model
{
    use HasFactory; 
    use SoftDeletes;

    protected $fillable = [
        'instructor_id',
        'recorded_by', 
        'schedule_id', 
        'event_id', 
        'status', 
        'date'
    ];

    //relationship with instructor
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    //relationship with schedule
    public function schedule()
    {
        return $this->belongsTo(Schedule::class)->with('karateClassTemplate');
    }

    //relationship with event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
