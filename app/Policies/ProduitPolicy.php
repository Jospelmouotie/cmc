<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Produit;

use Illuminate\Auth\Access\HandlesAuthorization;

class ProduitPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->isAdmin() && $user->isGestionnaire()) {

            return true;
        }
    }



    public function view(User $user, Produit $produit = null)
    {
        return in_array(auth()->user()->role_id, [
            1,3,7
        ]);
    }


    public function create(User $user)
    {
        return in_array(auth()->user()->role_id, [
                1,3,7,5
            ]);
    }


    public function update(User $user)
    {
        return in_array(auth()->user()->role_id, [
            1,3,7,5
        ]);
    }


    public function delete(User $user, Produit $produit)
    {
        //
    }

    public function edit(User $user)
    {
        //
    }

    public function print(User $user)
    {
        return in_array(auth()->user()->role_id, [
            1,3,5,2
        ]);
    }

    public function anesthesiste()
    {
        return in_array(auth()->user()->id, [
            1,12,
        ]);

    }

}
