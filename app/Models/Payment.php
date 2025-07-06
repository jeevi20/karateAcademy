<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
   

    protected $fillable = [
        'student_id',
        'created_by',
        'reference_no',
        'payment_category',
        'amount',
        'date_paid',
        'admission_card_path',
        'notes',
        'belt_want_to_receive',
        'event_id'
    ];

    //relationship with student
    public function student()
{
    return $this->belongsTo(User::class, 'student_id');
}





    //relationship with user (branch staff) who recorded the payment
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // generate reference number for payment
    protected static function booted()
    {
        static::creating(function ($payment) {
            $payment->reference_no = self::generateReferenceNo();
        });

        
    }

    //generate refrence number
    public static function generateReferenceNo()
    {
        $prefix = "PAY"; // fixed prefix 
        $date = now()->format('Ymd'); // YYYYMMDD format
        $lastPayment = self::latest('id')->first(); // Fetche recent Payment record based on id
        $nextId = $lastPayment ? $lastPayment->id + 1 : 1; //next ID

        return sprintf("%s_%s_%03d", $prefix, $date, $nextId); //sprintf - sprcified format for string
    }

    
}
