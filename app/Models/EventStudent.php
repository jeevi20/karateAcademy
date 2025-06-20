<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventStudent extends Model
{
    use HasFactory;

    protected $table = 'event_student';
    
    protected $fillable = [
        'event_id',
        'student_id',
        'belt_want_to_receive',
        'result',
        'review',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }


    public function desiredBelt()
    {
        return $this->belongsTo(Belt::class, 'belt_want_to_receive');
    }
}

