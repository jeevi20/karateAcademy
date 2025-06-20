<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certification extends Model
{
    use HasFactory;

    protected $fillable =   [ 
        'user_id', 
        'certification_type', 
        'issued_date', 
        'distributed', 
        
        
        ];
}
