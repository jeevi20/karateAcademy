<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    
    protected $fillable = [
        'role_id',
        'role_name'
        
    ];

    //Relationship with user
    public function users()
    {
        return $this->hasMany(User::class);
    }

}
