<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Auth\Access\HandlesAuthorization;

class PatientPolicy
{
    use HandlesAuthorization;


    public function before(User $user, $ability)
    {
        if ($user->isAdmin() && $user->isCaisse() && $user->isMedecin()) {

            return true;
        }
    }

    public function view(User $user, Patient $patient)
    {
        return true;
    }


    public function create(User $user)
    {
        return in_array(auth()->user()->role_id, [
            1,2,6,4,9,3
        ]);
    }


    public function update(User $user)
    {
        return in_array(auth()->user()->role_id, [
            1,2,6,4,9
        ]);
    }

    public function print(User $user)
    {
        return in_array(auth()->user()->role_id, [
            1,6,9
        ]);

    }

    // public function print_devis(User $user)
    // {
    //     return in_array(auth()->user()->role_id, [
    //         1,6,2
    //     ]);

    // }

    public function delete(User $user)
    {
        return in_array(auth()->user()->role_id, [
            1
        ]);

    }

    public function consulter()
    {
        return in_array(auth()->user()->role_id, [
            1,2,4,6
        ]);

    }

    public function infirmier()
    {
        return in_array(auth()->user()->role_id, [
            4
        ]);

    }

    public function infirmier_secretaire()
    {
        return in_array(auth()->user()->role_id, [
            1,4,6
        ]);

    }

    public function medecin_secretaire()
    {
        return in_array(auth()->user()->role_id, [
            1,2,6
        ]);

    }

    public function infirmier_chirurgien()
    {
        return in_array(auth()->user()->role_id, [
            1,4,2
        ]);

    }

    public function secretaire()
    {
        return in_array(auth()->user()->role_id, [
            1,6
        ]);

    }

    public function medecin()
    {
        return in_array(auth()->user()->role_id, [
            1,2
        ]);

    }

    public function med_inf_anes()
    {
        return in_array(auth()->user()->role_id, [
            1,2,4
        ]);

    }

    // public function anesthesiste()
    // {
    //     return in_array(auth()->user()->id, [
    //         1,15,28
    //     ]);

    // }

    public function anesthesiste()
    {
        $user = auth()->user();
        return $user->isAnesthesiste();
    }

    // public function chirurgien()
    // {
    //     return in_array(auth()->user()->id, [
    //         13,14,16,17,18,19,20,21,22,23,24,1
    //     ]);

    // }

    /**
     * Check if user is a chirurgien (based on specialty, not user ID)
     */
    public function chirurgien()
    {
        $user = auth()->user();
        return $user->isChirurgien() || $user->isPediatre() || $user->isGeneraliste();
    }

}











