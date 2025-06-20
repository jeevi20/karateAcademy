<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'body',
        'announcement_date',
        'image',
        'is_active',
        'audience',
        'created_by'        
    ];

    // Cast announcement_date to a Carbon instance for easy date handling
    protected $casts = [
        'announcement_date' => 'date',
        'is_active' => 'boolean',
    ];

    //relationship with users(created_by)
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    //to only get published announcements
    public function scopePublished($query)
    {
        return $query->where('is_active', true);
    }


    //soft delete
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($announcement) {   
            // Store the deleted event in the trash table
            Trash::storeDeletedRecord($announcement);
        });
    }

}

