<?php

namespace App\Http\Middleware;

use App\Http\Helpers\Helper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RouteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authUser = Auth::user();

        if (!$authUser->developer) {
            if (!$authUser->role) {
                Auth::logout();
                return redirect()->route('login');
            }

            $routeName = $request->route()->getName();
            $isPostRequest = $request->isMethod('post');

            if ($routeName != 'dashboard' && $routeName != 'users.edit' && !$this->userHasPermission($authUser, $routeName)) {
                if (!$isPostRequest) {
                    return Helper::handleUnauthorizedGetRequest($request);
                }

                return Helper::returnResponse(false, 'You don\'t have the permission');
            }
        }

        return $next($request);
    }

    /**
     * Check if the user has permission for the given route.
     *
     * @param  mixed  $user
     * @param  string  $route
     * @return bool
     */
    private function userHasPermission($user, $route): bool
    {
        $permissions = $user->role->permissions->pluck('name')->toArray();
        return in_array($route, $permissions);
    }

    /**
     * Handle unauthorized GET request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
}
