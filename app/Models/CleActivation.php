<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CleActivation extends Model
{
    public $timestamps = false;

    public function licence()
    {
        $this->belongsTo(\App\Models\Licence::class);
    }
}
