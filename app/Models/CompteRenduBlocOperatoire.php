<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CompteRenduBlocOperatoire extends Model
{
    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
