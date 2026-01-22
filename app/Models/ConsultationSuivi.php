<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultationSuivi extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'patient_id',
        'user_id',
        'interrogatoire',
        'commentaire',
        'date',
        
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
