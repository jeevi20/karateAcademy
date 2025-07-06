<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Schedule extends Model
{
    use HasFactory; 
    use SoftDeletes;

    protected $fillable = [
        'karate_class_template_id', 
        'schedule_date', 
        'status', 
        'instructor_id',
        'branch_id'
    ];

    /**
     * Define relationship with KarateClassTemplate
     */
    public function karateClassTemplate()
    {
        return $this->belongsTo(KarateClassTemplate::class, 'karate_class_template_id');
    }

    /**
     * Define relationship with Instructor (User)
     */
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function students()
    {
        
        return $this->belongsToMany(User::class, 'schedule_student', 'schedule_id', 'student_id')->where('role_id', 4); 
    }


    /**
     * Relationship: A schedule has many student attendances.
     */
    public function studentAttendances()
    {
        return $this->hasMany(StudentAttendance::class, 'schedule_id');
    }

    public function instructorAttendances()
    {
        return $this->hasMany(InstructorAttendance::class, 'schedule_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    // protected static function booted()
    // {
    //     static::addGlobalScope('autoComplete', function (Builder $builder) {
    //         $builder->with('karateClassTemplate')->get()->each(function ($schedule) {
    //             if (
    //                 $schedule->status === 'scheduled' &&
    //                 Carbon::parse($schedule->schedule_date . ' ' . $schedule->karateClassTemplate->end_time)->isPast()
    //             ) {
    //                 $schedule->updateQuietly(['status' => 'completed']);
    //             }
    //         });
    //     });
    // }

    
    // Soft delete
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($schedule) {
            
            // Store the deleted schedule in the trash table
            Trash::storeDeletedRecord($schedule);
        });
 
    }

}
