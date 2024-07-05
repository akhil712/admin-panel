<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Helper;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auth = Auth::user();
        $users = User::query();
        if (!$auth->developer) {
            if (count($auth->role->childRoles)) {
                $users = $users->whereIn('role_id', $auth->role->childRoles->pluck('id'));
            } else {
                $users = $users->where('id', $auth->id);
            }
        }
        $data['users'] = $users->get();
        return view('users.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $auth = Auth::user();
        $roles = Role::all();
        if (!$auth->developer) {
            if ($auth->role->childRoles->isNotEmpty()) {
                $roles = $auth->role->childRoles;
            } else {
                return Helper::handleUnauthorizedGetRequest($request);
            }
        }
        $data['roles'] = $roles;
        return view('users.createEdit',$data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, User $user)
    {
        $data['current'] = $user;
        $auth = Auth::user();
        $roles = Role::all();

        if (!$auth->developer) {
            if ($user->id == $auth->id) {
                $roles = collect([$auth->role]);
            } else {
                if (isset($user->role) && $auth->role->childRoles->contains($user->role)) {
                    $roles = $auth->role->childRoles;
                } elseif (!isset($user->role) && $auth->role->parentRoles->isEmpty()) {
                    $roles = $auth->role->childRoles;
                } else {
                    return Helper::handleUnauthorizedGetRequest($request);
                }
            }
        }

        $data['roles'] = $roles;
        return view('users.createEdit', $data);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . ($request->id ?: 'NULL') . ',id',
            'role_id' => 'required|exists:roles,id',
            'password' => 'string|min:8'.(isset($request->id) ? '|nullable' : '|required'),
        ]);

        $data = $request->only(['name', 'email', 'role_id']);
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        if ($request->id) {
            $user = User::findOrFail($request->id);
            $user->update($data);
        } else {
            $user = User::create($data);
        }
        return Helper::returnResponse(true,'User saved successfully',[]);
    }
}
