<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Fiche;
use Illuminate\Auth\Access\HandlesAuthorization;

class FichePolicy
{
    use HandlesAuthorization;



    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {

            return true;
        }
    }

    public function view(User $user, Fiche $fiche)
    {
        return true;
    }


    public function create(User $user)
    {
        return in_array(auth()->user()->role_id, [
            1,8
        ]);
    }


    public function update(User $user, Fiche $fiche)
    {
        return in_array(auth()->user()->role_id, [
            1,8
        ]);
    }

    public function delete(User $user, Fiche $fiche)
    {
        //
    }
}
