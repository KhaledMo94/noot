<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\ServiceProvidersCreatedEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);

        if ($request->has('permissions')) {
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);
        }

        return redirect()->route('admins.roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        // Prevent modification of super-admin role name
        if ($role->name === 'super-admin' && $request->name !== 'super-admin') {
            return redirect()->route('roles.edit', $role)
                ->with('error', 'Cannot change the name of super-admin role.');
        }

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles')->ignore($role->id)
            ],
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        DB::transaction(function () use ($request, $role) {
            // Update role name if it's not super-admin
            if ($role->name !== 'super-admin') {
                $role->update(['name' => $request->name]);
            }

            // Sync permissions - get permission models first
            if ($request->has('permissions')) {
                $permissions = Permission::whereIn('id', $request->permissions)->get();
                $role->syncPermissions($permissions);
            } else {
                $role->syncPermissions([]);
            }
        });

        return redirect()->route('admins.roles.index')
            ->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        if ($role->name === 'super-admin') {
            return redirect()->route('admins.roles.index')->with('error', 'Cannot delete super admin role.');
        }

        $role->delete();
        return redirect()->route('admins.roles.index')->with('success', 'Role deleted successfully.');
    }
}
