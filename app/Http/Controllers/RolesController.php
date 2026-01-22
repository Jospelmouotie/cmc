<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Cache;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('id', 'asc')->paginate(50);

        return view('admin.roles.index', compact('roles')); // Fixed: 'roles' not 'role'
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:20', 'unique:roles'],
        ]);
        $role = new Role();
        $role->name = $request->name;
        $role->save();
        Cache::tags(['roles'])->flush();
        return redirect()->route('roles.index')->with('success',"Votre nouveau role a bien été ajouté");
    }

    public function show($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.roles.show', compact('role')); 
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        Cache::tags(['roles'])->flush();
        return view('admin.roles.edit', compact('role')); 
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:20', 'unique:roles'],
        ]);
        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->save();
        
        Cache::tags(['roles', 'users'])->flush();
        return redirect()->route('roles.index')->with('success',"Le role a bien été modifier");
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();
        
        Cache::tags(['roles', 'users'])->flush();
        return redirect()->route('roles.index')->with('success', 'Le role a bien été supprimé');
    }
}