<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'branch_name',
        'branch_code',
        'province_code',
        'branch_address',
        'email',
        'phone_no'
        
    ];

    //relationship with users
    public function users()
    {
        return $this->hasMany(User::class);
    }

    //relationship with kclasses
    public function kclasses()
    {
        return $this->hasMany(Kclass::class);
    }

    //To create Branch Code Dynamically
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($branch) 
        {
            $branch->branch_code = self::generateBranchCode($branch->branch_name, 'NP');
        });

        //soft deletes
        static::deleting(function ($branch) {
            
            // Store the deleted branch in the trash table
            Trash::storeDeletedRecord($branch);
        });
    }

    
    public static function generateBranchCode($branchName, $provinceCode = 'NP')
    {
        $prefix = strtoupper(substr($branchName, 0, 3)); // First 3 letters of branch name
        $count = self::count() + 1; // Count of existing branches + 1
        return  $provinceCode. '-' . $prefix . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
    }


    //relationship with Classes (KarateClassTemplate) all karate classes belonging to a branch.
    public function classes()
    {
        return $this->hasMany(KarateClassTemplate::class);
    }

    //relationship with Schedules all scheduled sessions of the branch's classes
    public function schedules()
    {
        return $this->hasManyThrough(Schedule::class, KarateClassTemplate::class, 'branch_id', 'class_id');
    }

    //relationship with students
    public function students()
    {
        return $this->hasManyThrough(Student::class, User::class, 'branch_id', 'user_id', 'id', 'id');
    }

    //relationship with instructors
    public function instructors()
    {
        return $this->hasMany(Instructor::class, 'user_id', 'id');
    }

    

    

    

}
