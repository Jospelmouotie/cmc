<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionMedicale extends Model
{
    protected $guarded = [];

    // public $timestamps = false;
       public $timestamps = true;

    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
    public function adminPrescriptionMedicales()
    {
        return $this->hasMany(\App\Models\AdminPrescriptionMedicale::class);
    }
}
