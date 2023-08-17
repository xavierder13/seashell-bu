<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class SpeciesMaintenance
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
        
        //Species Record
        if($request->is('api/species2/index')){
            if($user->can('species-list')){
                return $next($request); 
            }
        }

        //Species Create
        if($request->is('api/species2/create') || $request->is('api/species2/store')){
            if($user->can('species-create')){
                return $next($request); 
            }
        }

        //Species Edit
        if($request->is('api/species2/edit/*') || $request->is('api/species2/update/*')){
            if($user->can('species-edit')){
                return $next($request); 
            }
        }

        //Species Delete
        if($request->is('api/species2/delete')){
            if($user->can('species-delete')){
                return $next($request); 
            }
        }

        //Species Import Data
        if($request->is('api/species2/import_species')){
            if($user->can('species-import')){
                return $next($request); 
            }
        }

        //Species Export Data
        if($request->is('api/species2/export_species')){
            if($user->can('species-export')){
                return $next($request); 
            }
        }

        //Species Export Data
        if($request->is('api/species2/publish')){
            if($user->can('species-publish')){
                return $next($request); 
            }
        }

        return abort(401, 'Unauthorized');
    }
}
