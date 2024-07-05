<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Helper;
use App\Models\Role;
use App\Models\RoleRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect(route('role-permissions.index'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.createEdit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $request->validate([
            'name' => 'required|unique:roles,name,'.$data['id'],
        ]);
        $save = Role::updateOrCreate([
            'id' => $data['id']
        ],$data);
        if(isset($save->id)){
            return Helper::returnResponse(true,'Data Saved',[],route('role-permissions.index'));
        }
        return Helper::returnResponse(true,'Data Not Saved');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['current'] = Role::find(base64_decode(urldecode($id)));
        return view('roles.createEdit',$data);
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Helper::deleteRecord(base64_decode(urldecode($id)),'roles');
    }

    /**
     * Update the specified resource in storage.
     */
    public function hierarchyStore(Request $request)
    {
        $roleIds = $request->input('role_ids');
        RoleRelation::truncate();
        foreach ($roleIds as $key => $roleId) {
            $parentRole = Role::findOrFail($roleId);
            if ($key < count($roleIds)-1) {
                $subRoles = array_slice($roleIds,$key+1);
                foreach ($subRoles as $childRoleId) {
                    $childRole = Role::findOrFail($childRoleId);
                    $parentRole->childRoles()->attach($childRole);
                }
            }
        }

        return Helper::returnResponse(true,'Roles Relations Saved Successfully');
    }

    
    public function hierarchyIndex()
    {
        $auth = Auth::user();
        if($auth->developer){
            $data['roles'] = Role::all();
        }
        else {
            if ($auth->role) {
                $data['roles'] = $auth->role->childRoles;
            }
        }
        return view('roles.hierarchy',$data);
    }
}
