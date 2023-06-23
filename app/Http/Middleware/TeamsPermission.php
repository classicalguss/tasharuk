<?php
namespace App\Http\Middleware;

class TeamsPermission{

	public function handle($request, \Closure $next){
		if(!empty(auth()->user())){
			// session value set on login
			setPermissionsTeamId(auth()->user()->school_id);
		}

		return $next($request);
	}
}