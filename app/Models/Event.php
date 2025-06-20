<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 
        'event_type', 
        'start_time', 
        'end_time', 
        'location', 
        'description', 
        'created_by',
        'event_date',
        'status'

    ];


    //relationship with branch
    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_id');
    }

    //relationship with creator(user)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // public function branch()
    // {
    //     return $this->belongsTo(Branch::class);
    // }

   
    public function eventStudents()
{
    return $this->hasMany(EventStudent::class);
}

public function students()
{
    return $this->belongsToMany(User::class, 'event_student', 'event_id', 'student_id')
                ->withPivot('belt_want_to_receive', 'result', 'review')
                ->withTimestamps();
}



    //relationship with studentAttendance
    public function studentAttendance()
    {
        return $this->hasMany(StudentAttendance::class, 'event_id');
    }

    //relationship with instructorAttendance
    public function instructorAttendance()
    {
        return $this->hasMany(InstructorAttendance::class, 'event_id');
    }

    public function gradingExamResults()
    {
        return $this->hasMany(GradingExamResult::class);
    }
    




    // Soft delete
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($event) {
            
            // Store the deleted event in the trash table
            Trash::storeDeletedRecord($event);
        });
 
    }



}