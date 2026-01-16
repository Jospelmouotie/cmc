<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use App\Models\Patient;
//use App\Models\PrescriptionMedicale;

class FichePrescriptionMedicale extends Model
{
    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function prescription_medicales()
    {
        return $this->hasMany(\App\Models\PrescriptionMedicale::class);
    }
}
