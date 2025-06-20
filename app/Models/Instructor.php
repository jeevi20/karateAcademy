<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instructor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'reg_no', 'style', 'exp_in_karate', 'exp_as_instructor', 'user_id', 'is_volunteer'
    ];

    protected $casts = [
        'is_volunteer' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function karateClasses()
    {
        return $this->hasMany(KarateClassTemplate::class, 'instructor_id');
    }

    public function enteredGradingResults()
    {
        return $this->hasMany(GradingExamResult::class, 'instructor_id');
    }

}

