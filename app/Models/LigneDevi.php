<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LigneDevi extends Model
{
    protected $guarded = [];

    public function devi()
    {
        return $this->belongsTo(\App\Models\Devi::class);
    }
}
