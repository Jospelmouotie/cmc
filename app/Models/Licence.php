<?php

namespace App\Models;

use App\Scopes\Licences\LicenceScopable;
use App\Scopes\Licences\PeriodLicenceAvaillableScopable;
use Illuminate\Database\Eloquent\Model;

class Licence extends Model
{
    use LicenceScopable, PeriodLicenceAvaillableScopable;

    protected $guarded = [];

    public $timestamps = false;

    public function cle_activations()
    {
        $this->hasMany(\App\Models\CleActivation::class);
    }
}
