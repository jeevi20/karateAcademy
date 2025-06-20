<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KarateClassTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'class_name', 
        'start_time', 
        'end_time', 
        'day'
    ];

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'karate_class_template_id');
    }

    // Soft delete
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($KarateClassTemplate) {
            
            // Store the deleted schedule in the trash table
            Trash::storeDeletedRecord($KarateClassTemplate);
        });
 
    }
}
