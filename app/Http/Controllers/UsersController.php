<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class UsersController extends Controller
{
    public function index()
    {
        $this->authorize('update', User::class);

        // Use 'role' instead of 'roles' to match the relationship
        $users = User::with('role')->orderBy('id', 'desc')->paginate(100);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $this->authorize('update', User::class);

        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->authorize('update', User::class);

        $rules = [
            'name' => ['required', 'string', 'max:100'],
            'lieu_naissance' => ['required', 'string', 'max:100'],
            'date_naissance' => ['nullable', 'date'],
            'prenom' => ['required', 'string', 'max:100'],
            'telephone' => ['required', 'unique:users', 'numeric', 'digits:9'],
            'sexe' => ['required'],
            'login' => ['required', 'string', 'min:6', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
        // If role is Medecin (2), specialty is required
        if ($request->roles == 2) {
            $rules['specialite'] = ['required', 'string'];
            $rules['onmc'] = ['required', 'string'];

            // If "Autre" is selected, require the custom specialty
            if ($request->specialite == 'Autre') {
                $rules['specialite_autre'] = ['required', 'string', 'max:100'];
            }
        }

        $this->validate($request, $rules);

        $user = new User();
        $user->name = $request->name;
        $user->prenom = $request->prenom;
        $user->onmc = $request->onmc;

        // If "Autre" selected, use custom specialty
        if ($request->specialite == 'Autre' && $request->specialite_autre) {
            $user->specialite = $request->specialite_autre;
        } else {
            $user->specialite = $request->specialite;
        }

        $user->lieu_naissance = $request->lieu_naissance;
        $user->date_naissance = $request->date_naissance;
        $user->telephone = $request->telephone;
        $user->sexe = $request->sexe;
        $user->login = $request->login;
        $user->role_id = $request->roles;
        $user->password = Hash::make($request->password);
        $user->save();

        Cache::flush();
        return redirect()->route('users.index')
            ->with('success', "L'utilisateur a bien été créé");
    }

    public function edit($id)
    {
        $roles = Role::all();
        $user = User::with('role')->findOrFail($id);
        Cache::flush();
        return view("admin.users.edit", compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', User::class);

        // CRITICAL FIX: Exclude current user from unique validation
        $rules = [
            'name' => ['required', 'string', 'max:100'],
            'lieu_naissance' => ['required', 'string', 'max:100'],
            'date_naissance' => ['nullable', 'date'],
            'prenom' => ['required', 'string', 'max:100'],
            'telephone' => ['required', 'unique:users,telephone,' . $user->id, 'numeric', 'digits:9'],
            'sexe' => ['required'],
            'login' => ['required', 'string', 'min:6', 'max:255', 'unique:users,login,' . $user->id],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];

         // If role is Medecin (2), specialty is required
        if ($request->roles == 2) {
            $rules['specialite'] = ['required', 'string'];
            $rules['onmc'] = ['required', 'string'];

            if ($request->specialite == 'Autre') {
                $rules['specialite_autre'] = ['required', 'string', 'max:100'];
            }
        }

        $request->validate($rules);

        $user->name = $request->name;
        $user->lieu_naissance = $request->lieu_naissance;
        $user->date_naissance = $request->date_naissance;
        $user->prenom = $request->prenom;
        $user->telephone = $request->telephone;
        $user->sexe = $request->sexe;
        $user->login = $request->login;
        $user->role_id = $request->roles;
        // If "Autre" selected, use custom specialty
        if ($request->specialite == 'Autre' && $request->specialite_autre) {
            $user->specialite = $request->specialite_autre;
        } else {
            $user->specialite = $request->specialite;
        }
        $user->onmc = $request->onmc;
        $user->password = Hash::make($request->password);
        $user->save();

        Cache::flush();
        Cache::forget('medecins_list');
        Cache::forget('users.role');

        return redirect()->route('users.index')
            ->with('success', "L'utilisateur a bien été modifié");

    }

    public function destroy(User $user)
    {
        $this->authorize('update', $user);
        $user->delete();

        Cache::flush();
        return redirect()->route('users.index')
            ->with('success', "L'utilisateur a bien été supprimé");
    }

    public function changePassword(Request $request, User $user)
    {
        $this->authorize('changePassword', User::class);

        $request->validate([
            'old_pass' => ['required', 'string', 'min:6'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $old_pass = $request->input('old_pass');
        $verifypass = password_verify($old_pass, $user->password);

        if (!$verifypass) {
            return redirect()->route('users.profile', $user->id)
                ->with('error', "L'ancien mot de passe est invalide");
        }

        $user->password = Hash::make($request->password);
        $user->save();

        Cache::flush();
        return redirect()->route('users.profile', $user->id)
            ->with('success', "Mot de passe mis à jour avec succès");
    }

    public function profile(Request $request, $id)
    {
        // Use 'role' instead of 'roles'
        $user = User::with('role')->findOrFail($id);
        return view("admin.users.profile", compact('user'));
    }
}

















