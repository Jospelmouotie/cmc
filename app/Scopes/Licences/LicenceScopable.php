<?php

namespace App\Scopes\Licences;

use App\Models\Licence;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait LicenceScopable
{


    public function scopeActiveLicenceKey(Builder $query)
    {

        $query->where('active_date', '=', null)
            ->where('client', 'cmcuapp');

        $query->update([

            'active_date' => Carbon::now()
        ]);
    }

    public function scopeDisableLicenceKey(Builder $query)
    {

        $query->where('expire_date', '<=', Carbon::now())
            ->where('client', 'cmcuapp');

        $query->update([

            'active_date' => null
        ]);
    }

}
