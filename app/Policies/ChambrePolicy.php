<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Chambre;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChambrePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {

            return true;
        }
    }

    public function view(User $user, Chambre $chambre)
    {
//
    }


    public function create(User $user)
    {
        return in_array(auth()->user()->role_id, [
            1,2,4,6
        ]);
    }


    public function update(User $user, Chambre $chambre)
    {
        return in_array(auth()->user()->role_id, [
            1,5
        ]);
    }

    public function delete(User $user, Chambre $chambre)
    {
//        return in_array(auth()->user()->role_id, [
//            1,5
//        ]);
    }


    public function restore(User $user, Chambre $chambre)
    {
        //
    }


    public function forceDelete(User $user, Chambre $chambre)
    {
        //
    }
}
