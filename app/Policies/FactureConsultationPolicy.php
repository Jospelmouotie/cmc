<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FactureConsultation;
use Illuminate\Auth\Access\HandlesAuthorization;

class FactureConsultationPolicy
{
    use HandlesAuthorization;

    
    public function update(User $user, FactureConsultation $factureConsultation)
    {
        return in_array(auth()->user()->role_id, [
            1,6
        ]);
    }

   
}
