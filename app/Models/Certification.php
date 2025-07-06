<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certification extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable =   [ 
        'user_id', 
        'certification_type', 
        'issued_date', 
        ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
