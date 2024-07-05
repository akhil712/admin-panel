<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RoleHasPermission;
use Illuminate\Support\Facades\DB;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auth = Auth::user();
        if ($auth->developer) {
            $data['roles'] = Role::all();
        } else {
            if ($auth->role) {
                $data['roles'] = $auth->role->childRoles;
            }
        }
        return view('rolePermissions.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $roleId = $request['role_id'];
        $permissions = $request['permissions'];
        $currentPermissions = RoleHasPermission::where('role_id', $roleId)->pluck('permission_id')->toArray();

        $permissionsToDelete = array_diff($currentPermissions, $permissions);

        DB::beginTransaction();

        try {
            RoleHasPermission::where('role_id', $roleId)
                ->whereIn('permission_id', $permissionsToDelete)
                ->delete();

            foreach ($permissions as $permissionId) {
                RoleHasPermission::updateOrCreate([
                    'role_id' => $roleId,
                    'permission_id' => $permissionId
                ]);
            }

            DB::commit();

            return Helper::returnResponse(true, 'Permissions saved successfully', [], route('role-permissions.index'));
        } catch (\Exception $e) {
            DB::rollBack();

            return Helper::returnResponse(false, 'Failed to save permissions', ['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['role'] = Role::find(base64_decode(urldecode($id)));
        $data['permissions'] = Permission::all()->groupBy(['type', 'category']);
        return view('rolePermissions.edit', $data);
    }
}
