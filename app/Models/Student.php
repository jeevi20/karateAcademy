<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'student_reg_no',
        'enrollment_date',
        'status',
        'user_id',
        'karate_class_template_id',
        'past_experience',
        'admission_granted'

    ];



    // relationship with belts
    public function belts()
    {
        return $this->belongsToMany(Belt::class);
    }

    public function belt()
{
    return $this->belongsTo(Belt::class, 'belt_id'); 
}

   



public function user()
{
    return $this->belongsTo(User::class);
}


public function branch()
{
    return $this->belongsTo(Branch::class);
}


    // public function achievements()
    // {
    //     return $this->hasMany(Achievement::class, 'student_id', 'id');
    // }

    
    public function achievements()
    {
        return $this->hasMany(Achievement::class, 'student_id');
    }



    public function karateClassTemplate()
    {
        return $this->belongsTo(KarateClassTemplate::class, 'karate_class_template_id');
    }

   

public function events()
{
    return $this->belongsToMany(Event::class, 'event_student','student_id', 'event_id')
        ->withPivot('is_admission_released')
        ->withTimestamps();
}



    public function gradingExamResults()
    {
        return $this->hasMany(GradingExamResult::class, 'student_id');
    }



    //create student_reg_no
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($student) {
            $student->student_reg_no = self::generateStudentRegNo();
        });


        static::deleting(function ($student) {
            // Delete related achievements
            $student->achievements()->delete();

            // Delete the related user 
            $student->user()->delete();
        });
    }

    
    public static function generateStudentRegNo()
    {
        // Get the latest student record, excluding soft-deleted ones
        $lastStudent = self::withTrashed()->orderBy('id', 'desc')->first();

        // Generate the new registration number based on the last student's reg number
        if (!$lastStudent || !$lastStudent->student_reg_no) {
            return 'S250001'; // Default start number if no records exist
        }
        $lastNumber = (int) substr($lastStudent->student_reg_no, 1);
        // Try generating a unique number by checking for existing entries (excluding soft-deleted)
        do {
            $newRegNo = 'S' . str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
            $exists = self::where('student_reg_no', $newRegNo)->whereNull('deleted_at')->exists();
            if (!$exists) {
                break;
            }
            $lastNumber++; // Increment the number until a unique reg no is found
        } while ($exists);
        return $newRegNo;
    }

    
    }

   


    
    


