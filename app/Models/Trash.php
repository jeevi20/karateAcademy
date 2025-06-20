<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trash extends Model
{
    use SoftDeletes;

    protected $table = 'trashes'; 

    protected $fillable = [
        'model_type',   
        'model_id',    
        'data',        
        'deleted_by',
    ];

    protected $casts = [
        'data' => 'array',  // Cast the 'data' column to an array
    ];

    public static function storeDeletedRecord($model)
    {
        // Store the model's data in the trash table when it is deleted
        self::create([
            'model_type' => get_class($model),  
            'model_id' => $model->id, 
            'data' => $model->toArray(), 
            'deleted_by' => auth()->id(), 
        ]);
    }
}

