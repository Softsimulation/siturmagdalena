<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Auth;

class Permissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permiso)
    {
        $arrayRoles = explode("|", $permiso);
        $user = User::where('id', \Auth::user()->id)->whereHas('permissions', function($q)use($arrayRoles){
            $q->whereIn('name',$arrayRoles);
        })->first();
        
        /*$user = User::whereHas('permissions', function ($query) use($permiso) {
            $query->where('name',$permiso);
        })->first();*/
        
        if($user == null){
            return \Redirect::to('/');
        }
        return $next($request);
    }
}