<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagerie extends Model
{
    protected $fillable = [
        'patient_id',
        'user_id',
        'radiographie' ,
        'echographie',
        'scanner',
        'irm',
        'scintigraphie',
        'autre',
        
       
    ] ;

    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
