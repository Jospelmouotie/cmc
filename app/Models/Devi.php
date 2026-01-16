<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Devi extends Model
{
    protected $guarded = [];
    
    public function modifiePar()
    {
        return $this->belongsTo(\App\Models\User::class);
    }


    public function ligneDevis()
    {
        return $this->hasMany(\App\Models\LigneDevi::class);
    }
}