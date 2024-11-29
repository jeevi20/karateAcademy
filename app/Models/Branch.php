<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    

    //relationship with users
    public function users()
    {
        return $this->hasMany(User::class);
    }

}
