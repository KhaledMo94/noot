<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\ServiceProvidersCreatedEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);

        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        return redirect()->route('admins.permissions.index')->with('success', 'Permission created successfully.');
    }

    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions')->ignore($permission->id)
            ],
        ]);

        $permission->update([
            'name' => $request->name
        ]);

        return redirect()->route('admins.permissions.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission)
    {
        // Check if permission is being used by any role
        if ($permission->roles()->count() > 0) {
            return redirect()->route('admins.permissions.index')
                ->with('error', 'Cannot delete permission that is assigned to roles. Please remove it from roles first.');
        }

        $permission->delete();
        return redirect()->route('admins.permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
