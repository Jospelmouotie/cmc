<?php

namespace App\Scopes\Licences;

use App\Models\Licence;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait PeriodLicenceAvaillableScopable
{


    public function scopeActiveLicenceOneMonth(Builder $query)
    {

        $query = Licence::where('active_date', '!=', null)
              ->where('client', 'cmcuapp')->first();

        $query->update([

            'expire_date' =>  Carbon::parse('1 month'),
        ]);
    }
}
