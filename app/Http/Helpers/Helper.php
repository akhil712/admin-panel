<?php

namespace App\Http\Helpers;

use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Helper
{
    static function returnResponse($status = false, $msg = '', $data = [], $url = null, $statusCode = 200)
    {
        return response()->json([
            'status' => $status,
            'msg' => $msg,
            'data' => $data,
            'url' => $url
        ], $statusCode);
    }


    static function getAddPageById($id = null)
    {
        if (isset($id)) {
            foreach (config('addPages') as $value) {
                if ($id == $value['id']) {
                    return $value;
                }
            }
        }
    }


    static function getRouteNames()
    {
        $return = [];
        $routes = Route::getRoutes();
        foreach ($routes as $key => $route) {
            if (in_array('permission', $route->middleware())) {
                if ('dashboard' == $route->getName() || $route->getName() == "") {
                    continue;
                }
                $return[] = [
                    'id' => $route->getName(),
                    'name' => ucwords(str_replace(['-', '.', '_'], ' ', $route->getName()))
                ];
            }
        }
        return $return;
    }

    static function createMenu()
    {
        $auth = Auth::user();
        if (!$auth->developer) {
            if (isset($auth->role)) {
                $permissions = $auth->role->permissions->where('type', config('constants.permissionType.menu.id'))->pluck('name');
            }
        }else {
            $permissions = Permission::where('type', config('constants.permissionType.menu.id'))->pluck('name');
        }
        return $permissions ?? [];
    }

    static function createMenuItemName($string) {
        $actions = ['index', 'create', 'destroy', 'edit', 'update', 'show', 'store'];
        return ucwords(str_replace(['_','-','.'],' ',str_replace($actions, '', $string)));
    }

    static function handleUnauthorizedGetRequest(Request $request)
    {
        $referer = $request->headers->get('referer');

        if (!$referer) {
            return redirect()->route('dashboard')->with([
                'status' => false,
                'msg' => 'You don\'t have access to this URL'
            ]);
        }

        return redirect()->back()->with([
            'status' => false,
            'msg' => 'You don\'t have access to this URL'
        ]);
    }

    static function deleteRecord($id,string $table)
    {
        if (isset($id) && isset($table) && $table !== '') {
            $delete = DB::table($table)->where('id',$id)->delete();
            if ($delete) {
                $status = true;
                $msg = 'Record deleted successfully.';    
            }
            else {

                $status = false;
                $msg = 'Record Not Deleted. Try again later';    
            }
        }
        else {
            $status = false;
            $msg = 'Table not found.';    
        }
        return Helper::returnResponse($status,$msg);
    }
    // static function dateStingToTimestampStore($date) {
    //     return $date.' 00:00:00';
    // }
}
