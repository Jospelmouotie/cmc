<?php

namespace App\Models;

use App\Models\FactureConsultation;
use Illuminate\Database\Eloquent\Model;

class HistoriqueFacture extends Model
{
    protected $guarded = [];

    public function facture_consultation()
    {
        return $this->belongsTo(\App\Models\FactureConsultation::class);
    }

    
}
