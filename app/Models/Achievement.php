<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Achievement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'belt_id',
        'achievement_type',
        'achievement_name',
        'achievement_date',
        'organization_name',
        'remarks',
    ];

    /**
     * Relationship: Achievement belongs to a student
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function user()
    {
        return $this->student->user(); 
    }
    



    //Relationship: Achievement belongs to a belt (optional)
     
    public function belt()
    {
        return $this->belongsTo(Belt::class);
    }

    /**
     * Accessor to format achievement_type
     */
    public function getFormattedAchievementTypeAttribute()
    {
        $types = [
            'past_belt' => 'Past Belt',
            'academy_belt' => 'Academy Belt',
            'certificate' => 'Certificate',
            'awards' => 'Award',
            'medal' => 'Medal',
        ];

        return $types[$this->achievement_type] ?? ucfirst(str_replace('_', ' ', $this->achievement_type));
    }

    /**
     * Soft delete - Move to trash before deleting
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($achievement) {
            Trash::storeDeletedRecord($achievement);
        });
    }
}
