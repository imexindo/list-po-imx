<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    public function indexRoles()
    {
        $roles = Role::orderBy('created_at', 'desc')->get();
        $permissions = Permission::orderBy('created_at', 'desc')->get();
        return view('pages.roles.index', compact('roles', 'permissions'));
    }


    public function storeRole(Request $request)
    {
        $request->validate(['name' => 'required']);
        Role::create(['name' => $request->name]);
        return redirect()->back()->with('success', 'Role created successfully.');
    }

    public function updateRole(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required',
            'permissions' => 'array',
            'permissions.*' => 'integer|exists:permissions,id'
        ]);

        // Update role name
        $role->update(['name' => $request->name]);

        // Convert permission IDs to integers
        $permissions = array_map('intval', $request->input('permissions', []));
        $role->syncPermissions($permissions);

        return redirect()->back()->with('success', 'Role updated successfully.');
    }

    public function destroyRole(Role $role)
    {
        $role->delete();
        return redirect()->back()->with('success', 'Role deleted successfully.');
    }

    public function indexPermissions()
    {
        $permissions = Permission::get();
        return view('pages.permissions.index', compact('permissions'));
    }

    public function storePermission(Request $request)
    {
        $request->validate(['name' => 'required']);
        Permission::create(['name' => $request->name]);
        return redirect()->back()->with('success', 'Permission created successfully.');
    }

    public function updatePermission(Request $request, Permission $permission)
    {
        $request->validate(['name' => 'required']);
        $permission->update(['name' => $request->name]);
        return redirect()->back()->with('success', 'Permission updated successfully.');
    }

    public function destroyPermission(Permission $permission)
    {
        $permission->delete();
        return redirect()->back()->with('success', 'Permission deleted successfully.');
    }

    public function getRolePermissions(Role $role)
    {
        return response()->json([
            'permissions' => $role->permissions->pluck('id')->toArray()
        ]);
    }

}
