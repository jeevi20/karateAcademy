<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'last_name', 'phone', 'address', 'gender',
        'nic', 'dob', 'email', 'password', 'role_id', 'branch_id'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($user) {
            if (!empty($user->nic)) {
                $user->password = Hash::make($user->nic);
            }
        });
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }


    public function instructor()
    {
        return $this->hasOne(Instructor::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }
    

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    
    public function recordedPayments(): HasMany
    {
        return $this->hasMany(Payment::class, 'created_by');
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }

    public function createdEvents()
    {
        return $this->hasMany(Event::class, 'created_by');
    }
    
    public function gradingEvents()
    {
        return $this->belongsToMany(Event::class, 'event_student', 'student_id', 'event_id')
                    ->withPivot('belt_want_to_receive', 'result', 'review')
                    ->withTimestamps();
    }
    

    public function karateClassTemplate()
    {
        return $this->belongsTo(KarateClassTemplate::class); 
    }


    public function gradingExams()
    {
        return $this->hasMany(GradingExam::class, 'student_id');
    }

    public function enteredExams()
    {
        return $this->hasMany(GradingExam::class, 'entered_by');
    }
    
}
