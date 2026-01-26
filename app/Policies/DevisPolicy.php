<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Devi;
use Illuminate\Auth\Access\HandlesAuthorization;

class DevisPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function before(User $user, $ability)
    {
        if ($user->isAdmin() && $user->isCaisse() && $user->isMedecin() && $user->isLogistique()) {

            return true;
        }
    }

    public function create(User $user)
    {
        return in_array(auth()->user()->role_id, [
            1,3,6
        ]);
    }


    public function update(User $user)
    {
        return in_array(auth()->user()->role_id, [
            1,3,6
        ]);
    }

    public function print(User $user)
    {
        return in_array(auth()->user()->role_id, [
            1,3,6
        ]);

    }
    public function view(User $user)
    {
        return in_array(auth()->user()->role_id, [
            1,3,6
        ]);

    }

    public function delete(User $user)
    {
        return in_array(auth()->user()->role_id, [
            1
        ]);

    }

}
