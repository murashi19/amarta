<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Ambil semua role
     */
    public function index()
    {
        return response()->json(Role::all());
    }

    // Buat role baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:roles,name',
            'description' => 'nullable|string|max:255',
        ]);

        $role = Role::create($request->only(['name', 'description']));

        return response()->json($role, 201);
    }

    // Detail role
    public function show(string $id)
    {
       return response()->json(Role::findOrFail($id));
    }

    // Update role
    public function update(Request $request, string $id)
    {
         $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string|max:50|unique:roles,name,' . $role->id,
            'description' => 'nullable|string|max:255',
        ]);

        $role->update($request->only(['name', 'description']));

        return response()->json($role);
    }

    // Hapus role
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return response()->json(['message' => 'Role deleted']);
    }
}
