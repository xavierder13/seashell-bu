<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class RoleMaintenance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        //Role Record
        if($request->is('api/role/index')){
            if($user->can('role-list')){
                return $next($request); 
            }
        }

        //Role Create
        if($request->is('api/role/create') || $request->is('api/role/store')){
            if($user->can('role-create')){
                return $next($request); 
            }
        }

        //Role Edit
        if($request->is('api/role/edit') || $request->is('api/role/update/*')){
            if($user->can('role-edit')){
                return $next($request); 
            }
        }

        //Role Delete
        if($request->is('api/role/delete')){
            if($user->can('role-delete')){
                return $next($request); 
            }
        }

        return abort(401, 'Unauthorized');
    }
}
