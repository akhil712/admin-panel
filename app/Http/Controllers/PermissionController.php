<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Helper;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['routes'] = Helper::getRouteNames();
        $permissions = Permission::all();
        $data['permissions'] = $permissions->groupBy('type')->toArray();
        return view('permissions.index',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'data.*.type' => 'required',
            'data.*.name' => 'required',
            'data.*.category' => 'required',
        ]);
        $data = $request->all();
        foreach ($data['data'] as $key => $value) {
            Permission::updateOrCreate([
                'id' => $key
            ],$value);
        }
        return Helper::returnResponse(true,'Data Saved');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Helper::deleteRecord(base64_decode(urldecode($id)),'permissions');
    }
}
