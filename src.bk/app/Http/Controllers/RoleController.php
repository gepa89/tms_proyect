<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function assignRole(Request $request, $userId)
    {
        $request->validate([
            'role_name' => 'required|string|exists:roles,name',
        ]);

        $user = User::findOrFail($userId);
        $role = Role::where('name', $request->role_name)->first();

        if (!$user->roles()->where('role_id', $role->id)->exists()) {
            $user->roles()->attach($role);
        }

        return response()->json(['message' => 'Role assigned successfully']);
    }

    public function removeRole(Request $request, $userId)
    {
        $request->validate([
            'role_name' => 'required|string|exists:roles,name',
        ]);

        $user = User::findOrFail($userId);
        $role = Role::where('name', $request->role_name)->first();

        if ($user->roles()->where('role_id', $role->id)->exists()) {
            $user->roles()->detach($role);
        }

        return response()->json(['message' => 'Role removed successfully']);
    }
}

