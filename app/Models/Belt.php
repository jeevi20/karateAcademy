<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Belt extends Model
{
    use HasFactory;

    protected $fillable = [
        'belt_name', 
        'rank', 
        'color', 
        'requirements', 
        'max_attempts',
        

    ];

    //relationship with students
    public function students()
    {
        return $this->belongsToMany(Student::class);
    }

    public function desiredReceivers()
{
    return $this->hasMany(EventStudent::class, 'belt_want_to_receive');
}


}

