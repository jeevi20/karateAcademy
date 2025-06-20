<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $fillable = [
        'user_id',
        'created_by',
        'reference_no', 
        'salary_status', 
        'payment_method', 
        'paid_amount', 
        'paid_date', 
        'notes'

    ];

    //relationship with users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //generate refrence no for salary payment
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($salary) {
            $salary->reference_no = self::generateReferenceNo();
        });
    }

    public static function generateReferenceNo()
    {
        $prefix = "SAL"; // fixed prefix 
        $date = now()->format('Ymd'); // YYYYMMDD format
        $lastPayment = self::latest('id')->first(); // Fetche recent Payment record based on id
        $nextId = $lastPayment ? $lastPayment->id + 1 : 1; //next ID
        return sprintf("%s_%s_%03d", $prefix, $date, $nextId); //sprintf - sprcified format for string

    }
}
